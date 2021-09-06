<?php namespace Otto\Article\Models;

use Backend\Facades\BackendAuth;
use Backend\Models\BackendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Model;

/**
 * Model
 */
class Article extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_article_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public static function boot()
    {


        self::creating(function($model){
            $model->slug = str_slug(request()->Article['title']);
            $model->creator_id = BackendAuth::getUser()->id;
        });

    }

    public $attachOne = [
        "cover_image" => "System\Models\File"
    ];

    public $attachMany = [
        "images" => "System\Models\File"
    ];    

    public $belongsToMany = [
        "categories" => [
            "Otto\Article\Models\Category",
            "table" => "otto_article_article_category",
            //"key" => "category_id",
            "order" => "sort_number"
        ],
        "tags" => [
            "Otto\Article\Models\Tag",
            "table" => "otto_article_article_tag",
            //"key" => "category_id",
            "order" => "sort_number"
        ]
    ];

    public $belongsTo = [
        "creator" => [
            "Backend\Models\User",
            "key" => "creator_id",
        ],
    ];


    public function getCreationMonthAttribute()
    {
        if($this->created_at){
            return $this->created_at->format('M');
        }
    }

    public function getCreationDayAttribute()
    {
        if($this->created_at){
            return $this->created_at->format('d');
        }
    }

}
