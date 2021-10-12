<?php namespace Otto\Personfinder\Models;

use Model;

/**
 * Model
 */
class Subscription extends Model
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
    public $table = 'otto_personfinder_subscriptions';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        "users" => [
            "Rainlab\User\Models\User",
            "table" => "users",
            "key" => "user_id",
        ]
    ];

    public $hasMany  = [
        "transactions" => [
            "Otto\Personfinder\Models\SubscriptionTransaction",
            "table" => "otto_personfinder_subscription_transactions",
            "key" => "subscription_id"
        ],
        "tokens" => [
            "Otto\Personfinder\Models\SubscriptionToken",
            "table" => "otto_personfinder_subscription_tokens",
            "key" => "subscription_id"
        ]
    ];
}
