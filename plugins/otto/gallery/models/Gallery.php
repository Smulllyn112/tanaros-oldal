<?php namespace Otto\Gallery\Models;

use Model;

/**
 * Model
 */
class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Sortable;

    const SORT_ORDER = 'sort_number';

    protected $dates = ['deleted_at'];

    protected $slugs = ['slug' => 'title'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_gallery_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        "cover_image" => "System\Models\File"
    ];

    public $attachMany = [
        "gallery_images" => "System\Models\File"
    ];    



}
