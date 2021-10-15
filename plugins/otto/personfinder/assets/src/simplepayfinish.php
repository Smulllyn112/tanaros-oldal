<?php

use Carbon\Carbon;
use Otto\Personfinder\Models\Subject;
use Otto\Personfinder\Models\Subscription;
use Otto\Personfinder\Models\SubscriptionTransaction;
use Illuminate\Support\Facades\Mail;

error_reporting(E_ALL);

ini_set('display_errors', '1');

// PARAMÉTEREK A SZÁMLA KIÁLLÍTÁSÁHOZ.
/*
* Név => $this["user"]->name
* Email => $this["user"]->email
* Ár => $this["simplepay_session"]->price
* Számla üzenet => $this["invoice_message"]
* country_code => "HU"
* 'post_code'=> $this["user"]->billing_zip,
* 'city' => $this["user"]->billing_city,
* 'address' => $this["user"]->billing_street
*/

//Import config data
require_once 'plugins/otto/personfinder/assets/src/config.php';


//Import SimplePayment class
require_once 'plugins/otto/personfinder/assets/src/SimplePayV21.php';

$trx = new SimplePayBack;
$trx->addConfig($config);

$this["user"] = $user = Auth::getUser();

//result
//-----------------------------------------------------------------------------------------
$this['result'] = array();

if (isset($_REQUEST['r']) && isset($_REQUEST['s'])) {
    if ($trx->isBackSignatureCheck($_REQUEST['r'], $_REQUEST['s'])) {
        $this['result'] = $trx->getRawNotification();
    }
}

//dd($this['result']);
if (array_get($this['result'], "e") === "SUCCESS" or array_get($this['result'], "e") === "FINISHED") {
    $simplepay_session = json_decode($this["user"]->simplepay_session);
    //dd($simplepay_session);
    $this["pay_type"] = $simplepay_session->type;
    $this["price"] = $simplepay_session->price;

   //dd("haha");

    if ($this["pay_type"] == "register") {
        $transaction = SubscriptionTransaction::where('reference', $this['result']['o'])->first();
        $transaction->simplepay_id = $this['result']['t'];
        $transaction->simplepay_status = $this['result']['e'];
        $transaction->save();

        /**
         * @var Subscription $subscription
         *
         */
        $subscription = $transaction->subscription;

        $subscription->status_id = 2;
        $subscription->recurring_cycles_completed = $subscription->recurring_cycles_completed + 1;
        $subscription->recurring_cycles_remaining = $subscription->recurring_cycles_remaining - 1;
        $subscription->recurring_last_payment_date = Carbon::now();
        $subscription->recurring_next_billing_date = Carbon::now()->modify('+'.$subscription->recurring_frequency_interval." ".$subscription->recurring_frequency);
        $subscription->save();

        $this["user"]->active_until = $simplepay_session->active_until;
        $this["user"]->save();
        $this["invoice_message"] = "Sikeres előfizetés a ". env("APP_NAME") . "alkalmazásban!";

        // email küldés adminnak, hogy lássuk hogy regisztrált hozzánk, és a felhasználónak is. 

        $vars = [

            "client_url" => env("APP_URL"). "/backend/rainlab/user/users/preview/". $this["user"]->id,

            "app_name" => env("APP_NAME"),

            "regards" => env("APP_REGARDS"),

            "name" => $this["user"]->name,

            "email" => $this["user"]->email,

            "subject" => "Sikeres regisztráció"
        ];

        Mail::send('otto.personfinder::mail.to_user_registered', $vars, function($message) use($vars) {

            $message->to($vars["email"]);

            $message->subject("Új regisztráció: ".env('APP_NAME'));

            $message->attach("themes/guest/assets/own/ebook6942342346876534534/ebook.pdf");
        });

        Mail::send('otto.personfinder::mail.to_admin_user_registered', $vars, function($message) use($vars) {

            $message->to(env("ADMIN_EMAIL"));

            $message->subject("Új regisztráció: ".env('APP_NAME'));
        });

    } elseif ($this["pay_type"] == "extra_kiemeles") {
        $this["user"]->extran_kiemelt_until = $simplepay_session->active_until;
        $this["user"]->save();
        $this["invoice_message"] = "Sikeres extra kiemelés előfiezés a ". env("APP_NAME") . "alkalmazásban!";

        // email az extra kiemelésről
        $vars = [
            "app_name" => env("APP_NAME"),

            "regards" => env("APP_REGARDS"),

            "name" => $this["user"]->name,
            "email"=> $this["user"]->email,
            "active_until" => $simplepay_session->active_until,
            "subject" => "Sikeres extra kiemelés!"
        ];

        Mail::send('otto.personfinder::mail.to_user_extra_kiemeles', $vars, function($message) use($vars) {

                $message->to($vars["email"]);

                $message->subject("Új extra kiemelés: ".env('APP_NAME'));
        });

    }elseif ($this["pay_type"] == "alap_kiemeles") {
        $this["user"]->alap_kiemelt_until = $simplepay_session->active_until;
        $this["user"]->save();
        $this["subject"] = Subject::find($simplepay_session->subject_id);

        foreach ($this["user"]->subjects as $subject) {
            if ($subject->id == $this["subject"]->id) {

                $subject->pivot->alap_kiemelt_until = $simplepay_session->active_until;

                $subject->pivot->save();

                $mainSubjName = $subject->name;
            }
        }

        $this["invoice_message"] = "Sikeres alap kiemelés előfiezés a ". env("APP_NAME") . "alkalmazásban $mainSubjName tantárgyból " . $simplepay_session->active_until . "ideig!";


        $vars = [
            "app_name" => env("APP_NAME"),

            "regards" => env("APP_REGARDS"),

            "name" => $this["user"]->name,
            "email"=> $this["user"]->email,
            "main_message" => $this["invoice_message"],
            "subject" => "Sikeres alap kiemelés!"
        ];

        Mail::send('otto.personfinder::mail.to_user_alap_kiemeles', $vars, function($message) use($vars) {

                $message->to($vars["email"]);

                $message->subject("Új alap kiemelés: ".env('APP_NAME'));
        });
    }

    $this["user"]->simplepay_session = null;
    //$this["user"]->save();

    // AZ ÚJ SZÁMLÁZÁS! CSAK MINTA ADATOK SZEREPELNEK BENNE!
    //dd("haha");

    $billingo = new \Otto\Personfinder\Classes\BillingoAPI;
    $partner = [

        'name' => $this["user"]->name,
        'address' => [
            'country_code' => 'HU',
            'post_code'=> $this["user"]->billing_zip,
            'city' => $this["user"]->billing_city,
            'address' => $this["user"]->billing_street
        ],
        'emails' => [
            $this["user"]->email
        ],
        // ezt be kell kérni ha nincsen, ez az asószám gondolom
        //'taxcode' => '123456789'

    ];

    $result = $billingo->createPartner($partner);

    //dd($result);
    //$itemUnitPrice = 1000;
    $itemUnitPrice = $this["price"];
    $unit = 'hónap';

    //$quantity = 1;
    $quantity = 1;

    $invoice = [
        'partner_id' => $result['id'],
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
                'name' => $this["invoice_message"],
                'unit_price' => $itemUnitPrice,
                'unit' => $unit,
                'unit_price_type' => 'net', // gross
                'vat' => '0%',
                //'vat' => '27%',
                'quantity' => $quantity,
                'comment' => $this["invoice_message"]
            ]
        ],
        'settings' => [
            'without_financial_fulfillment' => true, // csak bankkártyásnál igaz
        ]
    ];

    dd("megvagyunk!");

    $invoice = $billingo->createDocument($invoice);

    // levélben küldött számla URL
    /*$invoice_url = createInvoice([
        "megjegyzes" => $this["invoice_message"],
        "osszeg" => $this["price"],

        "client_name" => $this["user"]->name,
        "client_email" => $this["user"]->email,
        "client_country" => $this["user"]->billing_country,
        "client_city" => $this["user"]->billing_city,
        "client_postal_code" => $this["user"]->billing_zip,
        "client_street_name" => $this["user"]->billing_street,
    ]);*/

    if (isset($transaction)) {
        $transaction->invoice = $invoice['invoice_number'];
        $transaction->save();
    }
    // A RÉGIT KIKOMMENTELTÜK! AZ ÚJBAN CSAK PÉLDA ADATOK SZEREPELNEK!!!





    //az invoice elkészítése

    /* require_once("plugins/otto/personfinder/assets/billingo/create_invoice.php");



    try {

        $invoice_url = createInvoice([

            "megjegyzes" => $this["invoice_message"],

            "osszeg" => $this["price"],



            "client_name" => $this["user"]->name,

            "client_email" => $this["user"]->email,

            "client_country" => $this["user"]->billing_country,

            "client_city" => $this["user"]->billing_city,

            "client_postal_code" => $this["user"]->billing_zip,

            "client_street_name" => $this["user"]->billing_street,

        ]);

    } catch (JSONParseExceptionAlias $e) {

        echo "Error parsing response";

    } catch (RequestErrorExceptionAlias $e) {

        echo "Error in request";

    } catch (GuzzleException $e) {

        var_dump($e->getMessage());

    } */
}
