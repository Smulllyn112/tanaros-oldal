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
			"base" => "Alap??rtelmezett",	
			"theme_main_color" => "Sablon f??sz??ne",	
			"theme_secondary_color" => "Sablon m??sodik f??sz??ne",	
		];
	}

	public function getButtonColorOptions()
	{
		return [
			"base" => "Alap??rtelmezett (aj??nlott)",	
			"white" => "Feh??r",	
			"theme_main_color" => "Sablon m??sodik f??sz??ne",	
			"theme_secondary_color" => "Sablon m??sodik f??sz??ne",	
		];
	}

	public function defineProperties()
	{
		/* ezek jelennek meg, mint valaszthato optionok. */
		return [
			"showPhone" => [
				"title" => "Telefonsz??m megjelen??t??se",
				"type" => "checkbox",
				"default" => 1,
			],
			"showEmail" => [
				"title" => "Email megjelen??t??se",
				"type" => "checkbox",
				"default" => 1,
			],
			"showSubject" => [
				"title" => "T??rgy megjelen??t??se",
				"type" => "checkbox",
				"default" => 1,
			],
			"showName" => [
				"title" => "N??v megjelen??t??se",
				"type" => "checkbox",
				"default" => 1,
			],
			"showMessage" => [
				"title" => "??zenet megjelen??t??se",
				"type" => "checkbox",
				"default" => 1,
			],


			"phonePlaceholder" => [
				"title" => "Telefonsz??m alapsz??veg",
				"type" => "text",
				"default" => "...",
			],
			"emailPlaceholder" => [
				"title" => "Email alapsz??veg",
				"type" => "text",
				"default" => "...",
			],
			"subjectPlaceholder" => [
				"title" => "T??rgy alapsz??veg",
				"type" => "text",
				"default" => "...",
			],
			"namePlaceholder" => [
				"title" => "N??v alapsz??veg",
				"type" => "text",
				"default" => "...",
			],
			"messagePlaceholder" => [
				"title" => "??zenet alapsz??veg",
				"type" => "text",
				"default" => "...",
			],



			"phoneLabel" => [
				"title" => "Telefonsz??m Label",
				"descrition" => "A labelek megjelen??t??se eset??n fog l??tsz??dni.",
				"type" => "text",
				"default" => "Az ??n telefonsz??ma:",
			],
			"emailLabel" => [
				"title" => "Email Label",
				"descrition" => "A labelek megjelen??t??se eset??n fog l??tsz??dni.",
				"type" => "text",
				"default" => "Az ??n e-mail c??me:",
			],
			"subjectLabel" => [
				"title" => "T??rgy Label",
				"descrition" => "A labelek megjelen??t??se eset??n fog l??tsz??dni.",
				"type" => "text",
				"default" => "??zenet t??rgya: ",
			],
			"nameLabel" => [
				"title" => "N??v Label",
				"descrition" => "A labelek megjelen??t??se eset??n fog l??tsz??dni.",
				"type" => "text",
				"default" => "Az ??n neve:",
			],
			"messageLabel" => [
				"title" => "??zenet Label",
				"descrition" => "A labelek megjelen??t??se eset??n fog l??tsz??dni.",
				"type" => "text",
				"default" => "??zenet:",
			],



			"showLabels" => [
				"title" => "Label-ek megjelen??t??sre ker??ljenek?",
				"type" => "checkbox",
				"default" => 1,
			],
			"showCaptcha" => [
				"title" => "Nem vagyok robot mez?? megjelen??t??se",
				"type" => "checkbox",
				"default" => 1,
			],
			"areElementsBorderless" => [
				"title" => "Nem lekerek??tett elemek haszn??lata",
				"type" => "checkbox",
				"default" => 0,
			],

			"isButtonFullwidth" => [
				"title" => "A gomb teljes sz??less??g?? legyen?",
				"type" => "checkbox",
				"default" => 0,
			],
			"buttonBackground" => [
				"title" => "A gomb h??tt??r sz??ne",
				"type" => "dropdown",
				"default" => "base",
			],
			"buttonColor" => [
				"title" => "A gomb sz??ne",
				"type" => "dropdown",
				"default" => "base",
			],


			"marginTop" => [
				"title" => "Fels?? t??rk??z",
				"type" => "dropdown",
				"default" => 20,
			],
			"marginBottom" => [
				"title" => "Als?? t??rk??z",
				"type" => "dropdown",
				"default" => 20,
			],

		];
	}




	/*??zenetk??ld??s */
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

			"subject" => "Kapcsolatfelv??tel",
			"team_name" => env("APP_REGARDS")
		];


		Mail::send('otto.contact::mail.to_admin', $vars, function($message) {
		    $message->to(env('ADMIN_EMAIL', "??j kapcsolatfelv??tel-".env('APP_NAME')));
		    $message->subject('??j kapcsolatfelv??tel '. request()->name .' r??sz??r??l');
		});

		if(request()->email){
			Mail::send('otto.contact::mail.to_sender', $vars, function($message) {
			    $message->to(request()->email);
			    $message->subject('K??sz??nj??k megkeres??sed!');
			});
		}

		// amenniybnen redirectoltatni akarunk.
		return Redirect::to("/koszonjuk-a-megkeresest/");
	}

} 






?>