<?php namespace Otto\Reference\Models;

use Model;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_reference_category';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsToMany = [
        "references" => [
            "Otto\Reference\Models\Reference",
            "table" => "otto_reference_reference_category",
            "key" => "category_id",
            "order" => "sort_number"
        ]
    ];
}
