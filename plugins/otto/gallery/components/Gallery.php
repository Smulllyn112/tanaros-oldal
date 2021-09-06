<?php 
namespace Otto\Gallery\Components;

use Cms\Classes\ComponentBase;
use Otto\Gallery\Models\Gallery as GalleryModel;
class Gallery extends ComponentBase
{
	public $gallery;
	public $gallery_config;

	public function componentDetails()
	{
		return [
			"name" => "Szimpla képgaléria",
			"description" => "Képgaléria elem"
		];
	}

	public function onRun()
	{
		if($this->property('type') == "base"){
			$gallery = GalleryModel::findOrNew($this->property('galleryElement'));
		} else {
			$gallery = GalleryModel::all();
		}

		if($this->property('type') == "sortable"){
			$this->addJs('/plugins/otto/gallery/assets/js/filterizr.min.js');
			$this->addJs('/plugins/otto/gallery/assets/js/filterizr-config.js');
		}
		

		if($this->property('isLightboxGallery')){
			$this->addCss('/plugins/otto/gallery/assets/css/lightbox.min.css');
			$this->addJs('/plugins/otto/gallery/assets/js/lightbox.min.js');
			$this->addJs('/plugins/otto/gallery/assets/js/lightbox-config.js');
		}

		$this->gallery_config = $this->loadConfig();
		$this->gallery = $gallery;

	}

	protected function loadConfig()
	{
		$elements = [
			"items_per_row" => $this->property("itemsPerRow"), 
			"section_margin_top" => $this->property("sectionMarginTop"), 
			"section_margin_bottom" => $this->property("sectionMarginBottom"), 
			"grid_margin" => $this->property("gridMargin"), 
			"extra_effect" => $this->property("extraEffect"), 
			"img_ratio" => $this->property("imgRatio"), 
			"show_image_titles" => $this->property("showImageTitles"), 
			"is_lightbox_gallery" => $this->property("isLightboxGallery"), 
			"is_grayscale" => $this->property("isGrayscale"), 
			"type" => $this->property("type"), 
			"tab_color" => $this->property("tabColor"), 
			"active_tab_bg" => $this->property("activeTabBg"), 
			"cornered_tabs" => $this->property("corneredTabs"), 

		];

		return $elements;
	}


	public function getGalleryElementOptions()
	{
		$galleries = GalleryModel::all();
		$array = [];

		foreach($galleries as $gallery){
			$array[$gallery->id] = $gallery->title;
		}

		return $array;
	}

	public function getTypeOptions()
	{
		return [
			"base" => "alapértelmezett (Ajánlott)",
			"tabbed" => "Tab-os",
			"sortable" => "Sorbarendezhető",
		];
	}

	public function getItemsPerRowOptions()
	{
		return [
			2 => 2,
			3 => 3,
			4 => "4 (Ajánlott)",
		];
	}

	public function getSectionMarginTopOptions()
	{
		return [
			0 => "0 px",
			20 => "20 px",
			40 => "40 px",
			60 => "60 px",
			80 =>"80 px",
			100 => "100 px",
		];
	}

	public function getSectionMarginBottomOptions()
	{
		return [
			0 => "0 px",
			20 => "20 px",
			40 => "40 px",
			60 => "60 px",
			80 =>"80 px",
			100 => "100 px",
		];
	}

	public function getGridMarginOptions()
	{
		return [
			0 => "0 px",
			15 => "15 px",
			20 => "20 px",
			40 => "40 px",
			60 => "60 px",
		];
	}

	public function getImgRatioOptions()
	{
		return [
			1 => "1 : 1",
			"1.5" => "3 : 2",
		];
	}

	public function getExtraEffectOptions()
	{
		return [
			"base" => "Nincs effekt",
			"zoom" => "Zoom effekt",
			"thumbnail" => "Thumbnail",
		];
	}

	public function getActiveTabBgOptions()
	{
		return [
			"base" => "Alapértelmezett",
			"theme_main_color" => "Sablon főszíne",
			"theme_secondary_color" => "Sablon másodlagos főszíne",
		];
	}

	public function getTabColorOptions()
	{
		return [
			"base" => "Alapértelmezett",
			"black" => "Fekete",
			"theme_main_color" => "Sablon főszíne",
			"theme_secondary_color" => "Sablon másodlagos főszíne",
		];
	}

	public function defineProperties()
	{
		return [
			"galleryElement" => [
				"title" => "Melyik galériát szeretnéd betenni a listából?",
				"type" => "dropdown",
				"default" => 1,
				"required" => 1,
			],



			"itemsPerRow" => [
				"title" => "Képek száma egy sorban",
				"description" => "Ennyi kép fog megjelenni soronként.",
				"type" => "dropdown",
				"default" => 4,
			],

			"sectionMarginTop" => [
				"title" => "Szekció felső térköze",
				"type" => "dropdown",
				"default" => 40,
			],

			"sectionMarginBottom" => [
				"title" => "Szekció alsó térköze",
				"type" => "dropdown",
				"default" => 40,
			],

			"gridMargin" => [
				"title" => "Cikkek térköze",
				"type" => "dropdown",
				"default" => 40,
			],

			"extraEffect" => [
				"title" => "Extra effektus",
				"type" => "dropdown",
				"default" => "base",
			],

			"imgRatio" => [
				"title" => "Kép arány",
				"type" => "dropdown",
				
			],

			"showImageTitles" => [
				"title" => "Képek címeinek megjelenítése",
				"type" => "checkbox",
				"default" => 1,
			],


			"isLightboxGallery" => [
				"title" => "Legyen felugró",
				"type" => "checkbox",
				"default" => 1,
			],

			"isGrayscale" => [
				"title" => "Szürke effekt",
				"type" => "checkbox",
				"default" => 0,
			],		


			"type" => [
				"title" => "Típus",
				"description" => "Az alapértelmezett ajánlott. A Tab-os és a sorbarendezhető akkor ajánlott, ha több képgalériát szeretnél egyszerre megjeleníteni.",
				"type" => "dropdown",
				"default" => "base",
			],

			"activeTabBg" => [
				"title" => "Aktív gomb háttérszíne",
				"description" => "Amenniyben Tab-os vagy sorbarendezhető a típus, akkor adható meg.",
				"type" => "dropdown",
				"default" => "theme_main_color",
			],	

			"tabColor" => [
				"title" => "inaktív gomb színe",
				"description" => "Amenniyben Tab-os vagy sorbarendezhető a típus, akkor adható meg.",
				"type" => "dropdown",
				"default" => "theme_main_color",
			],		

			"corneredTabs" => [
				"title" => "Tabok szögletesek legyenek",
				"type" => "checkbox",
				"default" => 1,
			],	


		];
	}

	public function onSendContact(){
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

			"subject" => env('APP_NAME'),
			"team_name" => env('APP_NAME')
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