<?php namespace Otto\Personfinder\Models;

use Model;

/**
 * Model
 */
class Subject extends Model
{
    use \October\Rain\Database\Traits\Validation;
 
    public static $footerItems  = [
        "matematika",
        "angol",
        "francia",
        "német",
        "spanyol",
        "történelem",
        "irodalom",
        "magyar",
        "fizika",
        "földrajz",
        "biológia",
        "kémia",

        "zene",

        "műszaki rajz",
        "tanulásmódszertan",
        "marketing",
    ];   

    public $belongsToMany = [
        "teachers" => [
            "Rainlab\User\Models\User",
            "table" => "otto_personfinder_subject_to_user",
            "key" => "subject_id",
            "otherKey" => "user_id",
            "pivot" => ['alap_kiemelt_until']

        ]
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_personfinder_subject';

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
