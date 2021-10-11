<?php 

use Otto\Personfinder\Models\Subject;

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



$this["user"] = Auth::getUser();



//result

//-----------------------------------------------------------------------------------------

$this['result'] = array();

if (isset($_REQUEST['r']) && isset($_REQUEST['s'])) {

    if ($trx->isBackSignatureCheck($_REQUEST['r'], $_REQUEST['s'])) {

        $this['result'] = $trx->getRawNotification();

    }

}



//dd($this['result']);

//dd($this['result']);

if ($this['result']["e"] === "SUCCESS") {

	$simplepay_session = json_decode($this["user"]->simplepay_session);

    //dd($simplepay_session);

	$this["pay_type"] = $simplepay_session->type;

	$this["price"] = $simplepay_session->price;

   //dd("haha");

	if($this["pay_type"] == "register"){

		$this["user"]->active_until = $simplepay_session->active_until;

        $this["user"]->card_id = $this['result']['t'];

		$this["user"]->save();



		$this["invoice_message"] = "Sikeres előfizetés a ". env("APP_NAME") . "alkalmazásban!";

	} elseif($this["pay_type"] == "extra_kiemeles"){

		$this["user"]->extran_kiemelt_until = $simplepay_session->active_until;

		$this["user"]->save();



		$this["invoice_message"] = "Sikeres extra kiemelés előfiezés a ". env("APP_NAME") . "alkalmazásban!";

	}elseif($this["pay_type"] == "alap_kiemeles"){

		$this["user"]->alap_kiemelt_until = $simplepay_session->active_until;

		$this["user"]->save();

		$this["subject"] = Subject::find($simplepay_session->subject_id);

		foreach($this["user"]->subjects as $subject) {

			if($subject->id == $this["subject"]->id){

				$subject->pivot->alap_kiemelt_until = $simplepay_session->active_until; 

				$subject->pivot->save();
			}

		}



		$this["invoice_message"] = "Sikeres extra kiemelés előfiezés a ". env("APP_NAME") . "alkalmazásban!";

	}


	$this["user"]->simplepay_session = null;


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

            //'ide mi kerüljön? '
            $this["user"]->email
        ],

        // ez mi legyen?
        'taxcode' => '123456789'

    ];

    $result = $billingo->createPartner($partner);

    //$itemUnitPrice = 1000;
    $itemUnitPrice = $this["price"];

    //$unit = 'hónap';
    $unit = 'hónap';

    //$quantity = 1;
    $quantity = 1;

    //dd();

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

                'name' => 'Tétel neve',

                'unit_price' => $itemUnitPrice,

                'unit' => $unit,

                'unit_price_type' => 'net', // gross

                'vat' => '0%',
                //'vat' => '27%',

                'quantity' => $quantity,

                //'comment' => 'Komment'

                'comment' => $this["invoice_message"]

            ]

        ],

        'settings' => [

            'without_financial_fulfillment' => true, // csak bankkártyásnál igaz

        ]

    ];

    

    $invoice = $billingo->createDocument($invoice);

	

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









