<?php 

  //Optional error riporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    //Import config data
    require_once 'plugins/otto/personfinder/assets/src/config.php';

    //Import SimplePayment class
    require_once 'plugins/otto/personfinder/assets/src/SimplePayV21.php';

    $trx = new SimplePayStart;

    $currency = 'HUF';
    $trx->addData('currency', $currency);

    $trx->addConfig($config);

    //ORDER PRICE/TOTAL  
    //-----------------------------------------------------------------------------------------
    //dd($this["simplepay_session"]);
    $trx->addData('total', ($this["simplepay_session"])->price);


    $trx->addData('orderRef', str_replace(array('.', ':', '/'), "", @$_SERVER['SERVER_ADDR']) . @date("U", time()) . rand(1000, 9999));


    // CUSTOMER
    // customer's name
    //-----------------------------------------------------------------------------------------
    $trx->addData('customer', $this["user"]->name);




    // EMAIL
    // customer's email
    //-----------------------------------------------------------------------------------------
    $trx->addData('customerEmail', $this["user"]->email);


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
    //$trx->addData('methods', array('CARD'));
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

    $this['simple_pay_form'] =  $trx->returnData['form'];

?>