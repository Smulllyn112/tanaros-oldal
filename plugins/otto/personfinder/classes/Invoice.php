<?php

namespace Otto\Personfinder\Classes;

use Otto\Personfinder\Models\Subscription;
use Otto\Personfinder\Models\SubscriptionTransaction;
use RainLab\User\Models\User;

class Invoice
{
    protected $billingo = null;
    protected $invoiceMessage = null;

    public function __construct()
    {
        $this->billingo = new BillingoAPI();
    }

    public function create(Subscription $subscription, SubscriptionTransaction $transaction, $invoiceMessage = null)
    {
        $user = $subscription->user;

        $partner = $this->createPartner($subscription, $user);

        $invoice = [
            'partner_id' => $partner['id'],
            'type' => 'invoice', // díjbekérő: proforma
            'fulfillment_date' => date('Y-m-d'),
            'due_date' => date('Y-m-d'),
            'paid_date' => date('Y-m-d'), // csak bankkártya esetén
            'payment_method' => 'bankcard', // bankcard vagy wire_transfer
            'language' => 'hu',
            'currency' => 'HUF',
            'electronic' => true,
            'paid' => true, // bankkártya esetén az IPN-nél ez true
            'items' => [
                [
                    'name' => 'Előfizetés',
                    'unit_price' => $subscription->amount,
                    'unit' => 1,
                    'unit_price_type' => 'net', // gross
                    'vat' => '0%',
                    //'vat' => '27%',
                    'quantity' => 1,
                    'comment' => $invoiceMessage
                ]
            ],
            'settings' => [
                'without_financial_fulfillment' => true, // csak bankkártyásnál igaz
            ]
        ];

        $invoice = $this->billingo->createDocument($invoice);

        $transaction->invoice = $invoice['invoice_number'];
        $transaction->save();

        $this->billingo->sendDocument($invoice['id'], [
            $user->email
        ]);
    }

    protected function createPartner(Subscription $subscription, User $user)
    {
        $partner = [

            'name' => $user->name,
            'address' => [
                'country_code' => 'HU',
                'post_code'=> $user->billing_zip,
                'city' => $user->billing_city,
                'address' => $user->billing_street
            ],
            'emails' => [
                $user->email
            ],
            // ezt be kell kérni ha nincsen, ez az asószám gondolom
            //'taxcode' => '123456789'

        ];

        $result = $this->billingo->createPartner($partner);

        return $result;
    }
}
