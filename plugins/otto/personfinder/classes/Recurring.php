<?php

namespace Otto\Personfinder\Classes;

require_once 'plugins/otto/personfinder/assets/src/SimplePayV21.php';
require_once 'plugins/otto/personfinder/assets/src/SimplePayV21CardStorage.php';

use Carbon\Carbon;
use Otto\Personfinder\Models\Subscription;
use Otto\Personfinder\Models\SubscriptionToken;
use Otto\Personfinder\Models\SubscriptionTransaction;

class Recurring
{
    protected $config = [];

    public function __construct()
    {
        $this->config = include('plugins/otto/personfinder/assets/src/config.php');
    }

    public function process(Subscription $subscription)
    {
        /**
         * @var SubscriptionToken $token
         */
        $token = $subscription->tokens()->whereNull('simplepay_transaction_id')->first();
        if (!$token) {
            $subscription->status_id = 3;
            $subscription->recurring_state = 'NOT_ENOUGH_TOKEN';
            $subscription->save();

            //event(new NotEnoughRecurringToken($subscription));
            return false;
        }

        $user = $subscription->users;

        $transaction = new SubscriptionTransaction();
        $transaction->subscription_id = $subscription->getKey();
        $transaction->reference = 'TRANSACTION_'.uniqid();
        $transaction->created_at = Carbon::now();
        $transaction->save();

        $trx = new \SimplePayDorecurring;
        $trx->addConfig($this->config);
        $trx->addConfigData('merchantAccount', $this->config['HUF_MERCHANT']);

        $trx->addData('token', $token->simplepay_token);

        $trx->addData('orderRef', $transaction->reference);
        $trx->addData('methods', array('CARD'));
        $trx->addData('currency', 'HUF');
        $trx->addData('total', $subscription->amount);
        $trx->addData('customer', $user->name);
        $trx->addData('customerEmail', $user->email);
        $trx->addData('type', 'MIT');
        $trx->addData('threeDSReqAuthMethod', '02');

        $trx->runDorecurring();
        $result = $trx->getReturnData();

        $token->simplepay_transaction_id = $result['transactionId'];
        $token->save();

        $subscription->recurring_cycles_remaining = $subscription->recurring_cycles_remaining - 1;
        $subscription->recurring_cycles_completed = $subscription->recurring_cycles_completed + 1;
        $subscription->recurring_last_payment_date = Carbon::now();
        $subscription->recurring_next_billing_date = $this->calcPayDate(Carbon::now(), $subscription->recurring_frequency, $subscription->recurring_frequency_interval);
        $subscription->save();

        //Kiállítjuk a számlát -> itt be lehet állítani a kommentet is...
        (new Invoice())->create($subscription, $transaction);
    }

    protected function calcPayDate(Carbon $last, $frequency, $frequencyInterval, $multiple = 1)
    {
        $date = clone $last;

        return $date->modify('+'.($frequencyInterval * $multiple)." ".$frequency);
    }
}
