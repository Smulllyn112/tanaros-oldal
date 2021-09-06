<?php namespace Otto\Contact\Models;

use Model;

/**
 * Model
 */
class Contact extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'otto_contact_';

    /**
     * @var array Validation rules
     */
    public $rules = [
        
    ];
}
