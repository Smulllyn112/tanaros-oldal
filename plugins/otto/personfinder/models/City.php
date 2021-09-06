<?php namespace Otto\Personfinder\Models;

use Model;

/**
 * Model
 */
class City extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    public static $subscriptionPackages = [
        [
            "id" => 1,
            "duration" => 3,
            "price" => 3990,
            "is_default" => false
        ],
        [
            "id" => 2,
            "duration" => 6,
            "price" => 6990,
            "is_default" => false
        ],
        [
            "id" => 3,
            "duration" => 12,
            "price" => 11990,
            "is_default" => true
        ],
    ];

    public $belongsToMany = [
        "teachers" => [
            "Rainlab\User\Models\User",
            "table" => "otto_personfinder_city_to_user",
            "key" => "city_id",
            "otherKey" => "user_id",
        ]
    ];

    public static $egyhonaposKiemeles = 3990;

    public static $extraKiemelesEgyHonapra = 8990;

    public static $ajanlasiBonuszIdo = 2;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_personfinder_city';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function scopePublished(){
        return $this->where("is_published",1);
    }

    public function scopeOrder(){
        return $this->orderBy("sort_number","desc");
    }

    public static function getItemsList(){
        return self::published()->orderBy("sort_number","desc")->get();
    }
}
