<?php

use Billingo\API\Connector\Exceptions\JSONParseException as JSONParseExceptionAlias;
use Billingo\API\Connector\Exceptions\RequestErrorException as RequestErrorExceptionAlias;
//use Billingo\API\Connector\HTTP\Request as RequestAlias;
use Billingo\API\Connector\HTTP\Request as RequestAlias;
use GuzzleHttp\Exception\GuzzleException;

//dd(class_exists('Billingo\API\Connector\HTTP\Request'));


//require_once "vendor/autoload.php";








function createInvoice($params){
    //API konfiguráció
    $request = new RequestAlias([
        'private_key' => env('BILLINGO_API_PRIVATE_KEY'),
        'public_key' => env('BILLINGO_API_PUBLIC_KEY'),
    ]);

    //dd($params);

    /*
    * Szamla konfiguráció
    */
    // vázlat/piszkozat:0, proforma/díjbekérő:1, normál:3
    $szamla_tipus = 3; 
    $bankszamla_id = 1737434398; //  (lásd a 21.leckét!)
    $szamlatomb_id = 320879012; //  (lásd a 22.leckét!)

    $megjegyzes = "Sikeres számla kiállítás!";
    $teljesites = date("Y-m-d");
   // $hatarido = date("Y-m-d", time());
    $hatarido = date('Y-m-d', strtotime("+7 day"));

    $fizmod = 5; // készpénz:1, átutalás:2, utánvét:4, bankkártya:5,  PayPal:7, Barion:14 (lásd a 20.leckét!)

    // egyelőre csak egy terméket számlázunk ki
    $megnevezes = $params['megjegyzes']; // "Bérlet foglalás";
    $termek_megjegyzes = $params['megjegyzes']; // "Sikeres Bérlet foglalás";
    if(env("BILLINGO_TEST_MODE") == true){
        $fizetendo = 0; // ez a bruttó összeg
    } else {
        $fizetendo = $params['osszeg']; // ez a bruttó összeg
    }
    //print $fizetendo;
    $afa_kulcs = 992; // 27%:1, AAM:992, EU:5 (lásd a 23.leckét!)
    $mennyiseg = 1;
    $egyseg = "db";


    /* 
    * Ügyfél konfiguráció
    */
    $client_name = $params['client_name'];
    $client_email = $params['client_email'];

    $client_country = $params['client_country'];
    $client_city = $params['client_city'];
    $client_postal_code = $params['client_postal_code'];
    $client_street_name = $params['client_street_name'];

    if(isset($params['client_house_number'])){
        $client_house_number = $params['client_house_number'];
    }
    








/*
    $szamla_tipus = 3; 
    $bankszamla_id = 681846908; //  (lásd a 21.leckét!)
    $szamlatomb_id = 2006209994; //  (lásd a 22.leckét!)

    $megjegyzes = "Sikeres megrendelés!";
    $teljesites = date("Y-m-d");
   // $hatarido = date("Y-m-d", time());
    $hatarido = date('Y-m-d', strtotime("+7 day"));

    $fizmod = 5; // készpénz:1, átutalás:2, utánvét:4, bankkártya:5,  PayPal:7, Barion:14 (lásd a 20.leckét!)

    // egyelőre csak egy terméket számlázunk ki
    $megnevezes = "Bérlet foglalás";
    $termek_megjegyzes = "Bérlet foglalás";
    $fizetendo = 20; // ez a bruttó összeg
    //print $fizetendo;
    $afa_kulcs = 1; // 27%:1, AAM:992, EU:5 (lásd a 23.leckét!)
    $mennyiseg = 1;
    $egyseg = "db";
*/



    $clientData = [
      "name" => $client_name,
      "email" => $client_email,
      "billing_address" => [
        "country" => $client_country,
        "city" => $client_city,
        "postcode" => $client_postal_code,
        "street_name" => $client_street_name,
      ]
    ];




    /* 
    * Számla kiküldése
    */
    $eredmeny = $request->post('clients', $clientData);

    $ugyfel_billingo_id = $eredmeny["id"];

    //die(print_r($eredmeny["id"]));

    $szamlaAdatok = [
        "fulfillment_date" => $teljesites,
        "due_date" => $hatarido,
        "payment_method" => intval($fizmod),
        "comment" => $megjegyzes,
        "template_lang_code" => "hu",
        "electronic_invoice" => 0, // e-számla: 1
        "currency" => "HUF",
        "client_uid" => intval($ugyfel_billingo_id),
        "block_uid" => intval($szamlatomb_id),
        "type" => intval($szamla_tipus),
        "round_to" => 0,
        "bank_account_uid" => intval($bankszamla_id),
        "items" => [[
            "description" => $megnevezes,
            "vat_id" => intval($afa_kulcs),
            "qty" => intval($mennyiseg),
            "gross_unit_price" => intval($fizetendo),
            "unit" => $egyseg,
            "item_comment" => $termek_megjegyzes
        ]]
    ];

    // Elkészítjük a számlát:
    //====================================================================
    $eredmeny = $request->post('invoices', $szamlaAdatok);

    $szamla_billingo_id = $eredmeny["id"];

    //die("haha");

    $url_param = $request->get('invoices/'.$szamla_billingo_id.'/code')['code'];
    // NA EZ MÁR EGY LETÖLTHETŐ SZÁMLA
    $result = "<a href='https://www.billingo.hu/access/c:{$url_param}' target='_blank'>Link</a>";

    return $result;

}
