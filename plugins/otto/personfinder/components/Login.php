<?php 
namespace Otto\Personfinder\Components;

use Cms\Classes\ComponentBase;
use Flash;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\ValidationException;
use Rainlab\User\Facades\Auth;
use Rainlab\User\Models\User as FrontendUserModel;

class Login extends ComponentBase
{
	public $login_form_config;

	public function componentDetails()
	{
		return [
			"name" => "Frontend Login",
			"description" => "A session USER component kell a működéshez."
		];
	}

	public function onLogin()
	{
		$data = post();
		
		$rules = [
			"username" => "required|max:255",
			"password" => "required|max:255",

		];

		$validator = Validator::make($data,$rules);


		if($validator->fails())
		{
			throw new ValidationException($validator);
		}

		$user = Auth::authenticate([
		    'login' => post('username'),
		    'password' => post('password')
		]);	

		// ha redirecteltetős
		//if(Session::get('redirect_url')){
			Flash::success("Sikeres bejelentkezés!");
			return Redirect::to('/regisztracio-profil');
		//}
				
		
		

	}

	public function onRestoreSendMail()
	{
		$data = post();
		
		$rules = [
			"email" => "email|required|max:255",
		];

		$validator = Validator::make($data,$rules);


		if($validator->fails())
		{
			throw new ValidationException($validator);
		}

		$user = FrontendUserModel::where("email",post("email"))->first();

		if($user){
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < 200; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }

			//dd($randomString); 
			$user->restore_psw_slug = $randomString;
			$user->save();

			$vars = [
				"subject" => "email visszaállítása",
				"name" => $user->name,
				"url" => env("APP_URL") . "/jelszo-visszallitas/$randomString",
				"regards" => env("APP_REGARDS"),
				"email" => $user->email
			];

			Mail::send('otto.personfinder::mail.restore_psw', $vars, function($message) use($vars) {
			    $message->to($vars["email"]);
			    $message->subject("Jelszó visszaállítása: ".env('APP_NAME'));
			});

			Flash::success("Sikeres e-mail küldés, csekkold a postaládád!");
			return Redirect::to('/');
		} 
	}

	public function onNewPassword()
	{
		$data = post();
		
		$rules = [
			"password" => "required|max:255",
			"password_confirmation" => "required|max:255",
		];

		$validator = Validator::make($data,$rules);


		if($validator->fails())
		{
			throw new ValidationException($validator);
		}

		$user = FrontendUserModel::where("restore_psw_slug",\Request::segment(2))->first();

		if($user){
		    $user->fill(post());
			$user->save();

			$vars = [
				"subject" => "email visszaállítva",
				"name" => $user->name,
				"regards" => env("APP_REGARDS"),
				"email" => $user->email
			];

			Mail::send('otto.personfinder::mail.restored_psw', $vars, function($message) use($vars) {
			    $message->to($vars["email"]);
			    $message->subject("Jelszó visszaállítva: ".env('APP_NAME'));
			});

			Flash::success("Sikeres jelszó visszaállítás, be is jelentkezhetsz!");
			return Redirect::to('/');
		} 
	}
}