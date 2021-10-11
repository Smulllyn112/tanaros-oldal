<?php namespace Otto\Personfinder\Models;

use Model;

/**
 * Model
 */
class SubscriptionTransaction extends Model
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
    public $table = 'otto_personfinder_subscription_transactions';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        "subscription" => [
            "Otto\Personfinder\Models\Subscription",
            "table" => "subscriptions",
        ]     
    ];
}
