<?php



/**

 *  Copyright (C) 2020 OTP Mobil Kft.

 *

 *  PHP version 7

 *

 *  This program is free software: you can redistribute it and/or modify

 *   it under the terms of the GNU General Public License as published by

 *   the Free Software Foundation, either version 3 of the License, or

 *   (at your option) any later version.

 *

 *   This program is distributed in the hope that it will be useful,

 *   but WITHOUT ANY WARRANTY; without even the implied warranty of

 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

 *   GNU General Public License for more details.

 *

 *  You should have received a copy of the GNU General Public License

 *   along with this program.  If not, see http://www.gnu.org/licenses

 *

 * @category  SDK

 * @package   SimplePayV2_SDK

 * @author    SimplePay IT Support <itsupport@otpmobil.com>

 * @copyright 2020 OTP Mobil Kft.

 * @license   http://www.gnu.org/licenses/gpl-3.0.html  GNU GENERAL PUBLIC LICENSE (GPL V3.0)

 * @link      http://simplepartner.hu/online_fizetesi_szolgaltatas.html

 */



//Optional error riporting

error_reporting(E_ALL);

ini_set('display_errors', '1');



//Import config data

require_once 'plugins/otto/personfinder/assets/src/config.php';



//Import SimplePayment class

require_once 'plugins/otto/personfinder/assets/src/SimplePayV21_simple.php';



$trx = new SimplePayStart;



$currency = 'HUF';

$trx->addData('currency', $currency);



$trx->addConfig($config);




$trx->addData('total', $this["simplepay_session"]->price);




$trx->addData('orderRef', str_replace(array('.', ':', '/'), "", @$_SERVER['SERVER_ADDR']) . @date("U", time()) . rand(1000, 9999));

$trx->addData('threeDSReqAuthMethod', '02');



$trx->addData('customerEmail', $this["user"]->email);



$trx->addData('language', 'HU');




$timeoutInSec = 600;

$timeout = @date("c", time() + $timeoutInSec);

$trx->addData('timeout', $timeout);



$trx->addData('methods', array('CARD'));




$trx->addData('url', $config['URL']);


$trx->addGroupData('invoice', 'name', $this["user"]->name);

//$trx->addGroupData('invoice', 'company', '');

$trx->addGroupData('invoice', 'country', 'hu');

$trx->addGroupData('invoice', 'state', $this["user"]->billing_country);

$trx->addGroupData('invoice', 'city', $this["user"]->billing_city);

$trx->addGroupData('invoice', 'zip', $this["user"]->billing_zip);

$trx->addGroupData('invoice', 'address', $this["user"]->billing_street);

$trx->formDetails['element'] = 'button';




$trx->runStart();



$trx->getHtmlForm();



$this['simple_pay_form'] =  $trx->returnData['form'];

