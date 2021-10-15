<?php 

namespace Otto\Personfinder\Components;



use Cms\Classes\ComponentBase;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;

use October\Rain\Exception\ValidationException;

//use Mail;

use Otto\Contact\Models\Contact;

use Illuminate\Support\Facades\Redirect;



use Otto\Personfinder\Models\City;

use Otto\Personfinder\Models\Subject;

use Auth; 

use Flash;

use Carbon\Carbon;

use Rainlab\User\Models\User;

use Input;

use System\Models\File;



class Register extends ComponentBase

{

	public $form_config;





	public function componentDetails()

	{

		return [

			"name" => "register form",

			"description" => "register form"

		];

	}





	/*Regisztráció */

	public function onSend()

	{

		$data = post();

		//dd($data);

		

		$rules = [

			"name" => "required|max:255",

			"email" => "required|email|max:255",

			"phone" => "required|max:255",

			"excerpt" => "required|max:3000",

			"password" => "required|max:255",

			"description" => "required|max:3000",

			"hour_price" => "required",

			"billing_country" => "required|max:255",

			"billing_city" => "required|max:255",

			"billing_zip" => "required|max:255",

			"billing_street" => "required|max:255",

		];



		$validator = Validator::make($data,$rules);



		if($validator->fails())

		{

			throw new ValidationException($validator);

		}



		//dd(request()->all());

        //$nowTimeDate = Carbon::now();

        //$newTime = Carbon::now()->addMonths(6);

		//dd($nowTimeDate,$newTime);



		/*$adminAccs = User::where("email","viharos.otto@gmail.com")->orWhere("username","viharos.otto@gmail.com")->get();



		foreach($adminAccs as $acc){

			$num = rand(1,10000);

			$acc->email = $num."@gmail.com";

			$acc->username = $num."@gmail.com";

			$acc->save();

		}*/



		$packages = City::$subscriptionPackages;



		$package = array_values(array_filter($packages, function($el){

			//dd($el["id"],(int)post("package"));

			return $el["id"] == (int)post("package");

		}))[0];



        // TESZT //

        $duration = $package["duration"];

        // TESZT //

        

		$activeUntil = Carbon::now()->addMonths($duration)->format('Y-m-d');



		$jsonArr = [

			"active_until"=>$activeUntil,

			"price" =>  $package["price"],

			"type" => "register",

			"duration" => $duration

		];



		$simplepaySession = json_encode($jsonArr); 



		$user = Auth::register([

		    'name' => post("name"),

		    'slug' => str_slug(post("name").rand(1,1000)),

		    'email' => post("email"),

		    'phone' => post("phone"),

		    'hour_price' => post("hour_price"),

		    'is_going_to_house' => post("is_going_to_house"),

		    'password' => post("password"),

		    'password_confirmation' => post("password_confirmation"),



		    'personal_website' => post("personal_website"),

		    'group_teaching' => post("tgroup_teaching"),

		    'description' => post("description"),

		    'excerpt' => post("excerpt"),

		    'graduate' => post("graduate"),

		    'business_hours' => post("business_hours"),

		    'is_online_teaching' => post("is_online_teaching"),

		    'active_until' => NULL,

		    'simplepay_session' => $simplepaySession,

		    'is_published' => 0,

		    'is_activated' => 1,

		    'subscription_duration' =>$duration,



		    "billing_country" => post("billing_country"),

		    "billing_city" => post("billing_city"),

		    "billing_street" => post("billing_street"),

		    "billing_zip" => post("billing_zip"),

		]);



		$user = Auth::authenticate([

		    'login' => $user->email,

		    'password' => post('password')

		]);



		$file = (new File())->fromPost(Input::file("avatar"));

		if($file){

			$user->avatar()->add($file);

		}



		//dd($user);

		if($ajanloiEmail = post("ajanloi_email")){

				$ajanloUser = User::where("email",$ajanloiEmail)->first();

				if($ajanloUser){

				$currentActiveUntil = Carbon::parse($ajanloUser->active_until);



				//dd($ajanloUser,$currentActiveUntil);



				$newUntil = $currentActiveUntil->addMonths(City::$ajanlasiBonuszIdo);



				$ajanloUser->active_until = $newUntil;

				$ajanloUser->save();

			}

		}

		$user->subjects()->where("is_published",1)->detach();

		$user->subjects()->syncWithoutDetaching(post("subjects"));



		if(post("new_subject")){

			$subject = new Subject();

			$subject->name = post("new_subject");

			$subject->sort_number = Subject::min("sort_number") - 5;

			$subject->is_published = 0;



			$subject->save();

			$user->subjects()->syncWithoutDetaching($subject);

	        $vars = [

	            "item_url" => env("APP_URL"). "/backend/otto/personfinder/subject/update/". $subject->id,

	            "app_name" => env("APP_NAME"),

	            "regards" => env("APP_REGARDS"),

	            "name" => $subject->name,

	            "email" => $subject->email,

	            "subject" => "Új város / tantárgy"
	        ];

	        Mail::send('otto.personfinder::mail.to_admin_when_subjorcity_created', $vars, function($message) use($vars){

	            $message->to(env("ADMIN_EMAIL"));

	            $message->subject('Új város/tárgy a  '. env("APP_NAME")." alkalmazásban!" );
	        });
		}

		$user->cities()->where("is_published",1)->detach();

		$user->cities()->syncWithoutDetaching(post("cities"));



		if(post("new_city")){

			$city = new City();

			$city->name = post("new_city");

			$city->sort_number = City::min("sort_number") - 5;

			$city->is_published = 0;



			$city->save();

			$user->cities()->syncWithoutDetaching($city);

	        $vars = [

	            "item_url" => env("APP_URL"). "/backend/otto/personfinder/city/update/". $city->id,

	            "app_name" => env("APP_NAME"),

	            "regards" => env("APP_REGARDS"),

	            "name" => $city->name,

	            "email" => $city->email,

	            "subject" => "Új város / tantárgy"
	        ];

	        Mail::send('otto.personfinder::mail.to_admin_when_subjorcity_created', $vars, function($message) use($vars){

	            $message->to(env("ADMIN_EMAIL"));

	            $message->subject('Új város/tárgy a  '. env("APP_NAME")." alkalmazásban!" );
	        });

		}

		Flash::success("A regisztrációd első része sikeres volt! A fizetés után lesz a profilod aktiválható!");

		return Redirect::to("/fizetes");
	}





	public function onUpdate()

	{

		$data = post();

		//dd($data);

		

		$rules = [

			"name" => "required|max:255",

			"email" => "required|email|max:255",

			"phone" => "required|max:255",

			"excerpt" => "required|max:3000",

			"description" => "required|max:3000",

			"hour_price" => "required|max:400",

			"billing_country" => "required|max:255",

			"billing_city" => "required|max:255",

			"billing_zip" => "required|max:255",

			"billing_street" => "required|max:255",



		];



		$validator = Validator::make($data,$rules);



		if($validator->fails())

		{

			throw new ValidationException($validator);

		}



		//dd(request()->all());



		/*$packages = City::$packages;



		$duration = array_values(array_filter($packages, function($el){

			//dd($el["id"],(int)post("package"));

			return $el["id"] == (int)post("package");

		}))[0]["duration"];*/



		//$activeUntil = Carbon::now()->addMonths($duration);

		//dd(post());



		$user = Auth::getUser();

        $user->fill(post());

		//$user->phone = request()->phone;

        $user->save();



		$file = (new File())->fromPost(Input::file("avatar"));

		if($file){

			$user->avatar()->add($file);

		}

		$user->subjects()->where("is_published",1)->detach();

		$user->subjects()->syncWithoutDetaching(post("subjects"));



		if(post("new_subject")){

			$subject = new Subject();

			$subject->name = post("new_subject");

			$subject->slug = str_slug($subject->name);

			$subject->sort_number = Subject::min("sort_number") - 5;

			$subject->is_published = 0;



			$subject->save();

			$user->subjects()->where("is_published",1)->detach();

			$user->subjects()->syncWithoutDetaching($subject);



			$vars = [
				"item_url" => env("APP_URL"). "/backend/otto/personfinder/subject/update/". $subject->id,
				"msg" => "Új elem lett lett létrehozva alkalmazásunkban!",

				"email" => $user->email,

				"subject" => "Új tantárgy",

				"regards" => env("APP_REGARDS"),

				"name" => $user->name,

				"new_item" => $subject->name

			];



			Mail::send('otto.personfinder::mail.to_admin_when_subjorcity_created', $vars, function($message) use($vars){

			    $message->to(env("ADMIN_EMAIL"),$vars["email"]);

			    $message->subject('Új elem hozzáadva!');

			});



		}



		$user->cities()->where("is_published",1)->detach();



		$user->cities()->syncWithoutDetaching(post("cities"));



		if(post("new_city")){

			$city = new City();

			$city->name = post("new_city");

			$city->slug = str_slug($city->name);

			$city->sort_number = City::min("sort_number") - 5;

			$city->is_published = 0;



			$city->save();

			$user->cities()->where("is_published",1)->detach();

			$user->cities()->syncWithoutDetaching($city);





			$vars = [
				"item_url" => env("APP_URL"). "/backend/otto/personfinder/city/update/". $city->id,
				"msg" => "Új elem lett lett létrehozva alkalmazásunkban!",

				"email" => $user->email,

				"subject" => "Új tantárgy",

				"regards" => env("APP_REGARDS"),

				"name" => $user->name,

				"new_item" => $city->name

			];



			Mail::send('otto.personfinder::mail.to_admin_when_subjorcity_created', $vars, function($message) use($vars){

			    $message->to(env("ADMIN_EMAIL"),$vars["email"]);

			    $message->subject('Új elem hozzáadva!');

			});

		}



        Auth::login($user);



		Flash::success("Sikeres módosítások!");

		return back();





	}

} 

