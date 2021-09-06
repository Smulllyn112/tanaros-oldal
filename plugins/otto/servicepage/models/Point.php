<?php namespace Otto\Servicepage\Models;

use Model;

/**
 * Model
 */
class Point extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_servicepage_points';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsToMany = [
        "service_pages" => [
            "Otto\Servicepage\Models\ServicePage",
            "table" => "otto_servicepage_servicepage_points",
            //"key" => "servicepage_id",
            "order" => "sort_number"
        ]
    ];

    public $attachOne = [
        "image" => "System\Models\File",
    ];
}
