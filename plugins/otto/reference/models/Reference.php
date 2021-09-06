<?php 
namespace Otto\Reference\Models;

use Model;

/**
 * Model
 */
class Reference extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_reference_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public static function boot()
    {
        self::creating(function($model){
            //dd(request()->all());
            $model->slug = str_slug(request()->Reference['title']);

        });

        self::updating(function($model){
            $model->slug = str_slug(request()->Reference['title']);
        });
    }    

    protected $jsonable = ['points'];


    public $attachOne = [
        "image" => "System\Models\File"
    ];

    public $belongsToMany = [
        "categories" => [
            "Otto\Reference\Models\Category",
            "table" => "otto_reference_reference_category",
            "key" => "reference_id",
            //"order" => "sort_number"
        ]
    ];

}
