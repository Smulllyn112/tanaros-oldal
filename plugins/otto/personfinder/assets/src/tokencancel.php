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


/**
 * @var \RainLab\User\Models\User $user
 */
$user = $this["user"];

$subscribes = \Otto\Personfinder\Models\Subscription::query()
    ->where('user_id',$user->getKey())
    ->where('status_id',2)
    ->get();

/**
 * @var \Otto\Personfinder\Models\Subscription $item
 */
foreach ($subscribes as $item) {
    $tokens = \Otto\Personfinder\Models\SubscriptionToken::query()
        ->where('subscription_id',$item->getKey())
        ->whereNull('simplepay_transaction_id')
        ->get();

    /**
     * @var \Otto\Personfinder\Models\SubscriptionToken $token
     */
    foreach ($tokens as $token) {
        $trx = new SimplePayTokenCancel();
        $trx->addConfig($config);
        $trx->addConfigData('merchantAccount', $config['HUF_MERCHANT']);
        $trx->addData('token', $token->simplepay_token);
        $trx->runTokenCancel();

        $token->delete();
    }

    $item->status_id = 3;
    $item->save();
}

//start query
//-----------------------------------------------------------------------------------------






