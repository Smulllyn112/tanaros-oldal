<?php namespace Otto\Contact\Models;

use Model;

/**
 * Model
 */
class ContactStatic extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_contact_static';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
