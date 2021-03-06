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

        UserModel::deleted(function($model){
            //$model->subscriptions->destroy();
            /*foreach($model->subscriptions as $subscription){
                $subscription->destroy();
            }*/
        });

		UserModel::updating(function($model){
			if($model->isDirty('is_published') and $model->is_published == 0){
				$vars = [
					"regards" => env("APP_REGARDS"),
					"subject" => "Fi??k felf??ggeszt??se",
					"email" => $model->email,
					"name" => $model->name
				];

				Mail::send('otto.personfinder::mail.to_user_not_permitted', $vars, function($message) use($vars){
				    $message->to($vars["email"]);
				    $message->subject("Fi??k felf??ggeszt??se: ".env('APP_NAME'));
				});			
			} 

			if($model->isDirty('is_published') and $model->is_published == 1){
				//dd("most lett enged??lyezve");

				$vars = [
					"regards" => env("APP_REGARDS"),
					"subject" => "Sikeres aktiv??ci??",
					"email" => $model->email,
					"name" => $model->name

				];

				Mail::send('otto.personfinder::mail.to_user_permitted', $vars, function($message) use($vars){
				    $message->to($vars["email"]);
				    $message->subject("Sikeres aktiv??ci??: ".env('APP_NAME'));
				});
			} 

		});


    	UsersController::extendFormFields(function($form,$model,$context){
    		$form->addTabFields([
    			"is_online_teaching" => [
    				"label" => "Online tan??t?",
    				"type" => "checkbox",
    				"tab" => "Egy??ni"
    			],
    			"excerpt" => [
    				"label" => "R??vid le??r??s",
    				"type" => "textarea",
    				"tab" => "Egy??ni"
    			],
    			"description" => [
    				"label" => "Le??r??s",
    				"type" => "textarea",
    				"tab" => "Egy??ni"
    			],
    			"hour_price" => [
    				"label" => "??rab??r",
    				"type" => "textarea",
    				"tab" => "Egy??ni"
    			],
    			"phone" => [
    				"label" => "Telefonsz??m",
    				"type" => "text",
    				"tab" => "Egy??ni"
    			],
                "slug" => [
                    "label" => "Slug",
                    "type" => "text",
                    "tab" => "Egy??ni"
                ],
    			"graduate" => [
    				"label" => "Diploma, v??gzetts??g",
    				"type" => "textarea",
    				"tab" => "Egy??ni"
    			],
    			"business_hours" => [
    				"label" => "Jellemz??en r????r",
    				"type" => "textarea",
    				"tab" => "Egy??ni"
    			],
    			"personal_website" => [
    				"label" => "Szem??lyes weboldal",
    				"type" => "text",
    				"tab" => "Egy??ni"
    			],
    			"is_going_to_house" => [
    				"label" => "H??zhoz megy",
    				"type" => "checkbox",
    				"tab" => "Egy??ni"
    			],
    			"group_teaching" => [
    				"label" => "Csoportos tan??t??s",
    				"type" => "textarea",
    				"tab" => "Egy??ni"
    			],
    			"is_published" => [
    				"label" => "J??v??hagyott felhaszn??l??-e?",
    				"type" => "checkbox",
    				"tab" => "Egy??ni"
    			],
    			"active_until" => [
    				"label" => "Ed??fizet??s eddig ??rv??nyes",
    				"type" => "text",
    				"tab" => "Egy??ni"
    			],
    		]);
    	});
    }
}
