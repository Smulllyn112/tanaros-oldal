<?php namespace Otto\Personfinder\Models;

use Model;

/**
 * Model
 */
class SimplePay extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_personfinder_city';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public static function isSandboxMode(){
        return env("SIMPLE_PAY_TEST_MODE");
    }

    public static function simpleHufMerchant(){
        return env("SIMPLE_PAY_HUF_MERCHANT");
    }

    public static function simpleHufSecret(){
        return env("SIMPLE_PAY_HUF_SECRET");
    }


}
