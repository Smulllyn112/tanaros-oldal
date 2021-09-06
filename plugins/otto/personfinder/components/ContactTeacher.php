<?php 
namespace Otto\Personfinder\Components;

use Cms\Classes\ComponentBase;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\ValidationException;
use Rainlab\User\Facades\Auth;
use Rainlab\User\Models\User;
use Mail;

class ContactTeacher extends ComponentBase
{
	public $login_form_config;

	public function componentDetails()
	{
		return [
			"name" => "Tanár kapcsolat",
			"description" => "A tanároknak üzenetküldés."
		];
	}

	public function onSend()
	{
		$data = post();
		
		$rules = [
			"name" => "required|max:255",
			"email" => "required|email|max:255",
			"message" => "required|max:5000"
		];

		$validator = Validator::make($data,$rules);


		if($validator->fails())
		{
			throw new ValidationException($validator);
		}

		$user = User::where("slug",\Request::segment(2))->first();

		$vars = [
			"sender_email" => post("email"),
			"sender_name" => post("name"),
			"sender_phone" => post("sender_phone"),
			"sender_message" => post("message"),

			"teacher_email" => $user->email,
			"teacher_name" =>  $user->name,
			"app_name" => env("APP_NAME")
		];

		Mail::send('otto.personfinder::mail.teacher_contact', $vars, function($message) use($vars) {
		    $message->to($vars["sender_email"],$vars["teacher_email"]);
		    $message->subject("Új üzenetküldés: ".env('APP_NAME'));
		});




			Flash::success("Sikeres üzenetküldés!");
			return back();
		//}
				
		
		

	}
}