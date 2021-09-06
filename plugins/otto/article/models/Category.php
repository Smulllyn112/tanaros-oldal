<?php namespace Otto\Article\Models;

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
    public $table = 'otto_article_category';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public static function boot()
    {
        self::creating(function($model){
            $model->slug = str_slug(request()->Category['name']);
        });

        self::updating(function($model){
            $model->slug = str_slug(request()->Category['name']);
        });
    }

    public $belongsToMany = [
        "articles" => [
            "Otto\Article\Models\Article",
            "table" => "otto_article_article_category",
            //"key" => "category_id",
            "order" => "sort_number"
        ],
    ];
}
