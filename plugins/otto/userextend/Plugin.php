<?php namespace Otto\Userextend;

use System\Classes\PluginBase;
use Rainlab\User\Controllers\Users as UsersController;
use Rainlab\User\Models\User as UserModel;
use Mail;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

	public function boot(){
        /*UserModel::extend(function($model) {

            $model->belongsToMany['subjects'] = [
		            "Otto\Personfinder\Models\Subject",
		            "table" => "otto_personfinder_subject_to_user",
		            "key" => "user_id",
		            "otherKey" => "subject_id",
		            "order" => "sort_number"
		        ]
		    ];

            $model->belongsToMany['cities'] = [
		            "Otto\Personfinder\Models\City",
		            "table" => "otto_personfinder_city_to_user",
		            "key" => "user_id",
		            "otherKey" => "city_id",
		            "order" => "sort_number"
		        ];

            $model->attachOne["avatar"] = ["System\Models\File"];

            $model->attachMany["images"] = ["System\Models\File"];

        });*/


        UserModel::extend(function($model){
            $model->addFillable([
                "is_online_teaching",
                "excerpt",
                "description",
                "hour_price",
                "phone",
                "graduate",
                "is_activated",
                "business_hours",
                "personal_website",
                "is_going_to_house",
                "group_teaching",
                "slug",
                "is_published",
                "active_until",
                "subscription_duration",
                "extran_kiemelt_until",
                "alap_kiemelt_until",
                "restore_psw_slug",

                "billing_country",
                "billing_city",
                "billing_zip",
                "billing_street",
                "simplepay_session"
            ]);

            $model->belongsToMany['subjects'] = [
            	'Otto\Personfinder\Models\Subject', 
            	'key' => 'user_id',
          		'another_key' => 'subject_id',
            	'table' => 'otto_personfinder_subject_to_user',
                "pivot" => ['alap_kiemelt_until']

            ];

            $model->belongsToMany['cities'] = [
            	'Otto\Personfinder\Models\City', 
            	'key' => 'user_id',
          		'another_key' => 'city_id',
            	'table' => 'otto_personfinder_city_to_user',
            ];

            $model->attachMany["images"] = ["System\Models\File"];    

            $model->hasMany["subscriptions"] = [
                "Otto\Personfinder\Models\Subscription",
                "table" => "otto_personfinder_subscriptions",        
            ];   
          
        });

		UserModel::updating(function($model){
			if($model->isDirty('is_published') and $model->is_published == 0){
				$vars = [
					"regards" => env("APP_REGARDS"),
					"subject" => "Fiók felfüggesztése",
					"email" => $model->email,
					"name" => $model->name
				];

				Mail::send('otto.personfinder::mail.to_user_not_permitted', $vars, function($message) use($vars){
				    $message->to($vars["email"]);
				    $message->subject("Fiók felfüggesztése: ".env('APP_NAME'));
				});			
			} 

			if($model->isDirty('is_published') and $model->is_published == 1){
				//dd("most lett engedélyezve");

				$vars = [
					"regards" => env("APP_REGARDS"),
					"subject" => "Sikeres aktiváció",
					"email" => $model->email,
					"name" => $model->name

				];

				Mail::send('otto.personfinder::mail.to_user_permitted', $vars, function($message) use($vars){
				    $message->to($vars["email"]);
				    $message->subject("Sikeres aktiváció: ".env('APP_NAME'));
				});
			} 

		});


    	UsersController::extendFormFields(function($form,$model,$context){
    		$form->addTabFields([
    			"is_online_teaching" => [
    				"label" => "Online tanít?",
    				"type" => "checkbox",
    				"tab" => "Egyéni"
    			],
    			"excerpt" => [
    				"label" => "Rövid leírás",
    				"type" => "textarea",
    				"tab" => "Egyéni"
    			],
    			"description" => [
    				"label" => "Leírás",
    				"type" => "textarea",
    				"tab" => "Egyéni"
    			],
    			"hour_price" => [
    				"label" => "Órabér",
    				"type" => "textarea",
    				"tab" => "Egyéni"
    			],
    			"phone" => [
    				"label" => "Telefonszám",
    				"type" => "text",
    				"tab" => "Egyéni"
    			],
    			"graduate" => [
    				"label" => "Diploma, végzettség",
    				"type" => "textarea",
    				"tab" => "Egyéni"
    			],
    			"business_hours" => [
    				"label" => "Jellemzően ráér",
    				"type" => "textarea",
    				"tab" => "Egyéni"
    			],
    			"personal_website" => [
    				"label" => "Személyes weboldal",
    				"type" => "text",
    				"tab" => "Egyéni"
    			],
    			"is_going_to_house" => [
    				"label" => "Házhoz megy",
    				"type" => "checkbox",
    				"tab" => "Egyéni"
    			],
    			"group_teaching" => [
    				"label" => "Csoportos tanítás",
    				"type" => "textarea",
    				"tab" => "Egyéni"
    			],
    			"is_published" => [
    				"label" => "Jóváhagyott felhasználó-e?",
    				"type" => "checkbox",
    				"tab" => "Egyéni"
    			],
    			"active_until" => [
    				"label" => "Edőfizetés eddig érvényes",
    				"type" => "text",
    				"tab" => "Egyéni"
    			],
    		]);
    	});
    }
}
