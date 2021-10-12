<?php



//Optional error riporting

use Carbon\Carbon;
use Otto\Personfinder\Models\Subscription;
use Otto\Personfinder\Models\SubscriptionTransaction;

error_reporting(E_ALL);

ini_set('display_errors', '1');

//dd($this["simplepay_session"],$this["user"]);

//Import config data

require_once 'plugins/otto/personfinder/assets/src/config.php';

//Import SimplePayment class

require_once 'plugins/otto/personfinder/assets/src/SimplePayV21.php';

// PARAMÉTEREK AZ ISMÉTLŐDŐ FIZEtÉSHEZ. A levonási időintervallum még hiányzik.
/*	Név => $this["user"]->name
*	Email -> $this["user"]->email
*	Ár -> $this["simplepay_session"]->price
*	Idő intervallum, ami időnként levonogatja a zsét -> $this["simplepay_session"]->duration
*	Meddig vonogassa le -> örökké -> 2 év
*/

$month = 24;
$now = Carbon::now();
$end = (clone $now)->modify("+ ".$month." month");

$simplepaySession = $this["simplepay_session"];

/**
 * @var \October\Rain\Auth\Models\User $user
 */
$user = $this['user'];

/**
 * Statusz
 *  1: Függőben
    2: Folyamatban
    3: Lejárt
 */

/**
 * Lértehozunk neki egy új előfizetést mert vagy nem volt enki vagy lejárt...
 * Aktvra nem lehet ráhívni...
 */

$subscription = new Subscription();
$subscription->reference = 'SUBSCRIPTION_'.uniqid();
$subscription->user_id = $user->getKey();
$subscription->amount = $simplepaySession->price;
$subscription->recurring_cycle = $month / $simplepaySession->duration;
$subscription->recurring_cycles_remaining = $month / $simplepaySession->duration;
$subscription->recurring_cycles_completed =  0;
$subscription->recurring_frequency = 'month';
$subscription->recurring_frequency_interval = $simplepaySession->duration;
$subscription->recurring_start = $now;
$subscription->recurring_final_payment_date = $end;
$subscription->recurring_next_billing_date = null;
$subscription->recurring_last_payment_date = null;
$subscription->recurring_state = 'active';
$subscription->status_id = 1;
$subscription->save();

/**
 * Létrehozunk hozzá egy tranzakciót
 */
$transaction = new SubscriptionTransaction();
$transaction->subscription_id = $subscription->getKey();
$transaction->reference = 'TRANSACTION_'.uniqid();
$transaction->created_at = Carbon::now();
$transaction->save();

$trx = new SimplePayStart;

$currency = 'HUF';
$trx->addData('currency', $currency);
$trx->addConfig($config);

//number of claimed tokens (min 1, max 24)
$trx->addGroupData('recurring', 'times', $month / $simplepaySession->duration - 1);

//tokens expiration (min 1 hour, max 2 years)
//$trx->addGroupData('recurring', 'until', '2021-12-01T18:00:00+02:00');
$trx->addGroupData('recurring', 'until', $end->format('c'));

//Max paymentable amount per token (per transaction) in the currency of the account
$trx->addGroupData('recurring', 'maxAmount', $simplepaySession->price);

//ORDER PRICE/TOTAL

//-----------------------------------------------------------------------------------------
$trx->addData('total', $simplepaySession->price);
$trx->addData('orderRef', $transaction->reference);

// CUSTOMER
// customer's name
//-----------------------------------------------------------------------------------------
$trx->addData('customer', $user->name);
$trx->addData('threeDSReqAuthMethod', '02');
$trx->addData('type', 'MIT');

// EMAIL
// customer's email
//-----------------------------------------------------------------------------------------
$trx->addData('customerEmail', $user->email);

// LANGUAGE
// HU, EN, DE, etc.
//-----------------------------------------------------------------------------------------
$trx->addData('language', 'HU');

// TIMEOUT
// 2018-09-15T11:25:37+02:00
//-----------------------------------------------------------------------------------------
$timeoutInSec = 600;
$timeout = @date("c", time() + $timeoutInSec);
$trx->addData('timeout', $timeout);

// METHODS
// CARD or WIRE
//-----------------------------------------------------------------------------------------
$trx->addData('methods', array('CARD'));

// REDIRECT URLs
//-----------------------------------------------------------------------------------------
// common URL for all result
$trx->addData('url', $config['URL']);

//payment starter element
// auto: (immediate redirect)
// button: (default setting)
// link: link to payment page
//-----------------------------------------------------------------------------------------
$trx->formDetails['element'] = 'button';

//create transaction in SimplePay system
//-----------------------------------------------------------------------------------------
$trx->runStart();

//create html form for payment using by the created transaction
//-----------------------------------------------------------------------------------------
$trx->getHtmlForm();

$data = $trx->getReturnData();
$tokens = array_get($data, 'tokens');

foreach ($tokens as $token) {
    $subToken = \Otto\Personfinder\Models\SubscriptionToken::firstOrNew([
        'subscription_id' => $subscription->getKey(),
        'simplepay_token' => $token
    ]);

    $subToken->save();
}

$this['simple_pay_form'] =  $trx->returnData['form'];
