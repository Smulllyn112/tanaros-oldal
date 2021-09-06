<?php namespace Otto\Servicepage\Models;

use Model;

/**
 * Model
 */
class ServicePage extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_servicepage_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        "section_image" => "System\Models\File",
    ];

    public static function boot()
    {
       /* self::creating(function($model){
            $model->slug = str_slug(request()->ServicePage['title']);
        });

        self::updating(function($model){
            $model->slug = str_slug(request()->ServicePage['title']);
        }); */
    }

    public $belongsToMany = [
        "points" => [
            "Otto\Servicepage\Models\Point",
            "table" => "otto_servicepage_servicepage_points",
            //"key" => "servicepage_id",
            "order" => "sort_number"
        ]
    ];

    protected $jsonable = ['points'];


}
