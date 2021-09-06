<?php 
namespace Otto\Contact\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ValidationException;
//use Mail;
use Otto\Contact\Models\Contact;
use Illuminate\Support\Facades\Redirect;

class ContactForm extends ComponentBase
{
	public $form_config;


	public function componentDetails()
	{
		return [
			"name" => "contact form",
			"description" => "kontak form"
		];
	}

	public function onRun()
	{
		$this->form_config = $this->loadElements();
	}

	protected function loadElements()
	{
		$elements = [
			"show_phone" => $this->property("showPhone"), 
			"show_email" => $this->property("showEmail"), 
			"show_subject" => $this->property("showSubject"), 
			"show_name" => $this->property("showName"), 
			"show_message" => $this->property("showMessage"),

			"phone_placeholder" => $this->property("phonePlaceholder"), 
			"email_placeholder" => $this->property("emailPlaceholder"), 
			"subject_placeholder" => $this->property("subjectPlaceholder"), 
			"name_placeholder" => $this->property("subjectPlaceholder"), 
			"message_placeholder" => $this->property("subjectPlaceholder"), 

			"phone_label" => $this->property("phoneLabel"), 
			"email_label" => $this->property("emailLabel"), 
			"subject_label" => $this->property("subjectLabel"), 
			"name_label" => $this->property("nameLabel"), 
			"message_label" => $this->property("messageLabel"), 

			"show_labels" => $this->property("showLabels"), 
			"show_captcha" => $this->property("showCaptcha"), 
			"are_no_boder_radius" => $this->property("areElementsBorderless"), 

			"is_button_fullwidth" => $this->property("isButtonFullwidth"), 
			"button_background" => $this->property("buttonBackground"), 
			"button_color" => $this->property("buttonColor"), 

			"margin_top" => $this->property("marginTop"), 
			"margin_bottom" => $this->property("marginBottom"), 
		];

		return $elements;
	}




	public function getMarginTopOptions()
	{
		return [
			-20 => "-20px",
			-10 => "-15px",
			  0 => "0px",
			 10 => "10px",
			 20 => "20px",
			 40 => "40px",
			 50 => "50px",	
		];
	}

	public function getMarginBottomOptions()
	{
		return [
			-20 => "-20px",
			-10 => "-15px",
			  0 => "0px",
			 10 => "10px",
			 20 => "20px",
			 40 => "40px",
			 50 => "50px",	
		];
	}

	public function getButtonBackgroundOptions()
	{
		return [
			"base" => "Alapértelmezett",	
			"theme_main_color" => "Sablon főszíne",	
			"theme_secondary_color" => "Sablon második főszíne",	
		];
	}

	public function getButtonColorOptions()
	{
		return [
			"base" => "Alapértelmezett (ajánlott)",	
			"white" => "Fehér",	
			"theme_main_color" => "Sablon második főszíne",	
			"theme_secondary_color" => "Sablon második főszíne",	
		];
	}

	public function defineProperties()
	{
		/* ezek jelennek meg, mint valaszthato optionok. */
		return [
			"showPhone" => [
				"title" => "Telefonszám megjelenítése",
				"type" => "checkbox",
				"default" => 1,
			],
			"showEmail" => [
				"title" => "Email megjelenítése",
				"type" => "checkbox",
				"default" => 1,
			],
			"showSubject" => [
				"title" => "Tárgy megjelenítése",
				"type" => "checkbox",
				"default" => 1,
			],
			"showName" => [
				"title" => "Név megjelenítése",
				"type" => "checkbox",
				"default" => 1,
			],
			"showMessage" => [
				"title" => "Üzenet megjelenítése",
				"type" => "checkbox",
				"default" => 1,
			],


			"phonePlaceholder" => [
				"title" => "Telefonszám alapszöveg",
				"type" => "text",
				"default" => "...",
			],
			"emailPlaceholder" => [
				"title" => "Email alapszöveg",
				"type" => "text",
				"default" => "...",
			],
			"subjectPlaceholder" => [
				"title" => "Tárgy alapszöveg",
				"type" => "text",
				"default" => "...",
			],
			"namePlaceholder" => [
				"title" => "Név alapszöveg",
				"type" => "text",
				"default" => "...",
			],
			"messagePlaceholder" => [
				"title" => "Üzenet alapszöveg",
				"type" => "text",
				"default" => "...",
			],



			"phoneLabel" => [
				"title" => "Telefonszám Label",
				"descrition" => "A labelek megjelenítése esetén fog látszódni.",
				"type" => "text",
				"default" => "Az Ön telefonszáma:",
			],
			"emailLabel" => [
				"title" => "Email Label",
				"descrition" => "A labelek megjelenítése esetén fog látszódni.",
				"type" => "text",
				"default" => "Az Ön e-mail címe:",
			],
			"subjectLabel" => [
				"title" => "Tárgy Label",
				"descrition" => "A labelek megjelenítése esetén fog látszódni.",
				"type" => "text",
				"default" => "Üzenet tárgya: ",
			],
			"nameLabel" => [
				"title" => "Név Label",
				"descrition" => "A labelek megjelenítése esetén fog látszódni.",
				"type" => "text",
				"default" => "Az Ön neve:",
			],
			"messageLabel" => [
				"title" => "Üzenet Label",
				"descrition" => "A labelek megjelenítése esetén fog látszódni.",
				"type" => "text",
				"default" => "Üzenet:",
			],



			"showLabels" => [
				"title" => "Label-ek megjelenítésre kerüljenek?",
				"type" => "checkbox",
				"default" => 1,
			],
			"showCaptcha" => [
				"title" => "Nem vagyok robot mező megjelenítése",
				"type" => "checkbox",
				"default" => 1,
			],
			"areElementsBorderless" => [
				"title" => "Nem lekerekített elemek használata",
				"type" => "checkbox",
				"default" => 0,
			],

			"isButtonFullwidth" => [
				"title" => "A gomb teljes szélességű legyen?",
				"type" => "checkbox",
				"default" => 0,
			],
			"buttonBackground" => [
				"title" => "A gomb háttér színe",
				"type" => "dropdown",
				"default" => "base",
			],
			"buttonColor" => [
				"title" => "A gomb színe",
				"type" => "dropdown",
				"default" => "base",
			],


			"marginTop" => [
				"title" => "Felső térköz",
				"type" => "dropdown",
				"default" => 20,
			],
			"marginBottom" => [
				"title" => "Alsó térköz",
				"type" => "dropdown",
				"default" => 20,
			],

		];
	}




	/*Üzenetküldés */
	public function onSend()
	{

		$data = post();
		//dd($data);
		
		$rules = [
			"name" => "required|max:255",
			"email" => "email|max:255",
			"subject" => "max:255",
			"phone" => "max:255",
			"message" => "max:10000",

		];

		$validator = Validator::make($data,$rules);

		if($validator->fails())
		{
			throw new ValidationException($validator);
		}

		//dd(request()->all());

		$contact = new Contact();
		$contact->email = request()->get('email');
		$contact->name = request()->get('name');
		$contact->phone = request()->get('phone');
		$contact->subject = request()->get('subject');
		$contact->message = request()->get('message');
		$contact->save();

		$vars = [
			"name" => request()->get('name'),
			"email" => request()->get('email'),
			"phone" => request()->get('phone'),
			"msg" => request()->get('message'),
			"subject_from_sender" => request()->get('subject'),

			"subject" => "Kapcsolatfelvétel",
			"team_name" => env("APP_REGARDS")
		];


		Mail::send('otto.contact::mail.to_admin', $vars, function($message) {
		    $message->to(env('ADMIN_EMAIL', "Új kapcsolatfelvétel-".env('APP_NAME')));
		    $message->subject('Új kapcsolatfelvétel '. request()->name .' részéről');
		});

		if(request()->email){
			Mail::send('otto.contact::mail.to_sender', $vars, function($message) {
			    $message->to(request()->email);
			    $message->subject('Köszönjük megkeresésed!');
			});
		}

		// amenniybnen redirectoltatni akarunk.
		return Redirect::to("/koszonjuk-a-megkeresest/");
	}

} 






?>