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

 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.

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

require_once 'plugins/otto/personfinder/assets/src/SimplePayV21.php';



//Import SimplePayV21CardStorage 

require_once 'plugins/otto/personfinder/assets/src/SimplePayV21CardStorage.php';



$trx = new SimplePayCardCancel;



//config

$trx->addConfig($config);





//account

//----------------------------------------------------------------------------------------- 

$trx->addConfigData('merchantAccount', $config['HUF_MERCHANT']);





//add card ID

//-----------------------------------------------------------------------------------------    

$trx->addData('cardId', '501469312');

/*if (isset($_REQUEST['cardId'])) {

    $trx->addData('cardId', $_REQUEST['cardId']); // ITT KELL HOZZÁADNI A KÁRTYA SZÁMÁT, AMIT KORÁBBAN ELTÁROLTÁL

    //501469312

}  */  

                     



//start cancel

//-----------------------------------------------------------------------------------------                             

$trx->runCardCancel();



$trx->getHtmlForm();



dd($trx->returnData);



$this['simple_pay_form'] =  $trx->returnData['form'];



        

