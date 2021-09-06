<?php 
use Otto\Personfinder\Models\City;
use Otto\Personfinder\Models\Subject;
use Rainlab\User\Facades\Auth;
use Rainlab\User\Models\User;
use System\Models\File;
use Illuminate\Support\Facades\Validator;
use October\Rain\Support\Facades\Flash;
use Carbon\Carbon;

Route::get("/elofizetes-lemondasa",function(){
	$user = Auth::getUser();
	//dd($user);

	$simplepay_options = [
		"price" => "",
		"type" => "elofizetes_lemondasa",
		"active_until" => "",
	];

	//dd($user);

	$user->simplepay_session = json_encode($simplepay_options);
	$user->save();

	return Redirect::to("/fizetes");
})->middleware("web");


Route::get("/extra-kiemeles",function(){
	$user = Auth::getUser();
	//dd($user);

	$simplepay_options = [
		"price" => City::$extraKiemelesEgyHonapra,
		"type" => "extra_kiemeles",
		"active_until" => Carbon::now()->addMonths(1)->format('Y-m-d'),
	];

	//dd($user);

	$user->simplepay_session = json_encode($simplepay_options);
	$user->save();

	return Redirect::to("/fizetes");
})->middleware("web");


Route::post("/alap-kiemeles",function(){
	$user = Auth::getUser();
	//dd($user,post());

	$simplepay_options = [
		"price" => City::$egyhonaposKiemeles,
		"type" => "alap_kiemeles",
		"active_until" => Carbon::now()->addMonths(1)->format('Y-m-d'),
		"subject_id" => post("subject")
	];

	//dd($user);

	$user->simplepay_session = json_encode($simplepay_options);
	$user->save();

	return Redirect::to("/fizetes");
})->middleware("web");

/*
Route::get("/adas3423424",function(){
	$cities = City::all();
	foreach($cities as $city){
		$city->slug = str_slug($city->name);
		$city->save();
	}

	$subjects = Subject::all();
	foreach($subjects as $subject){
		$subject->slug = str_slug($subject->name);
		$subject->save();
	}

	dd("Vége! :D");
});
*/
// import cities
Route::get("/3htrzr424242",function(){
	/*$string = file_get_contents("themes/guest/assets/own/cities.json");  
	$cities = json_decode($string, true);

	$cities = array_filter($cities,function($el){
		return $el["population"] > 15000;
	});

	$baseSortNumber = 10000;

	foreach($cities as $city){
		$newCity = new City;
		$newCity->name = $city["city"];
		$newCity->sort_number = $baseSortNumber;
		$newCity->save();

		$baseSortNumber -= 5;
	}*/

	//dd("end");

	/*$subjects = [
		"matematika",
		"algebra",
		"geometria",
		"analízis",
		"matematika - általános iskola",
		"matematika - gimnázium",
		"matematika - egyetem",
		"gazdasági matematika",
		"lineáris algebra",
		"operációkutatás",
		"statisztika",

		"angol",
		"francia",
		"német",
		"holland",
		"spanyol",
		"latin",
		"lengyel",

		"földrajz",
		"történelem",
		"etika",
		"szociológia",

		"irodalom",
		"magyar",
		"magyar külföldieknek",
		"verselemzés",
		"esszé írás",
		"társadalomismeret",

		"testnevelés",
		"kosárlabda",
		"úszás",
		"foci",
		"tennisz",

		"fizika",
		"hőtan",
		"műszaki rajz",
		"gépelemek",
		"ábrázoló geometria",
		"AutoCad",
		"elektronika",
		"elektrotechnika",
		"jelek és rendszerek",
		"rezgéstan",
		"statika",

		"tanulásmódszertan",
		"beszédtechnika",

		"biológia",
		"kémia",
		"biokémia",
		"környezetismeret",
		"természetismeret",

		"rajz",
		"művészettörténet",


		"marketing",
		"közgazdaságtan",
		"makroökonómia",
		"mikroökonómia",
		"pénzügy",
		"számvitel",

		"jogi ismeretek",

		"informatika",
		"access",
		"excel",
		"adatbáziskezelés",

		"zene",
		"basszusgitár",
		"dobolás",
		"furulya",
		"fuvola",
		"hegedű",
		"cselló",
		"szolfézs",
		"zeneelmélet",
		"zongora"
	];

	$baseSortNumber = 10000;

	foreach($subjects as $subject){
		$newSubject = new Subject;
		$newSubject->name = $subject;
		$newSubject->sort_number = $baseSortNumber;
		$newSubject->save();

		$baseSortNumber -= 10;
	}*/

});


function isBoyByName($name,$boyArr){
		$lastName = explode(" ",$name);
		//dd($name,$lastName,$boyArr);
	if(in_array($lastName,$boyArr)){
		return true;
	} else {
		return false;
	}
}

function generatePhoneNumber(){
	$basicArr = [
		"0620",
		"3620",
		"0630",
		"0640",
		"3640",
		"0670",
		"3670"
	];

	$basicItem = $basicArr[array_rand($basicArr)];

	$remain = rand(1000000,9999999);

	return $basicItem.$remain;
}

function generateSingleItemsFromMultidimensionalArray($arr){

	$finalArr = array_map(function($subarr){
		return $subarr[array_rand($subarr)];
	},$arr);

	return $finalArr;
}


function addContactToDescription($introduction,$email,$phone){
		$num = rand(1,10);

		if($num < 3){
			$introduction = $introduction . " Az elérhetőségeim: $email, $phone";
		} elseif($num < 5){
			$introduction = $introduction . " Keress bátran: $email, $phone";	
		} elseif($num < 7){
			$introduction = $introduction . " Itt elérhetsz: $email, $phone";
		} else {
			$introduction = $introduction . " Itt könnyen elérhetsz: $email, $phone";
		}

		return $introduction;
}

function generateSingleStringFromMultiArray($arr){

	$simpleArr =  generateSingleItemsFromMultidimensionalArray($arr);

	return array_reduce($simpleArr,function($final,$el){
		return $final . $el;
	});
}

function generateSingleItemFromArray($arr){
	return $arr[array_rand($arr)];
}

// fake userek gyártása 
Route::get("/3htrzr424242",function(){
		$sentences = [
			[
				"Magántanárt keresel? Olyat, akivel a tanulás igazi játék lesz, nem csupán kínszenvedés? ",
				"Szeretnél órákat venni egy olyan magántanártól, aki tényleg érdekes, és szórakoztató órákat tart? ",
				"Szükséged lenne egy olyan magántanárra, aki a helyedbe tudja képzelni magát, és maximálisan kisegít mindenben? ",
				"Lenne kedved egy olyan magántanárral tanulni, aki hatalmas gyakorlattal rendelkezik tanítás, oktatás terén? ",
				"Szeretnél megismerni egy olyan magántanárt, aki gyakorlatilag minden kérdésedre tud válaszolni a keresett témakörből, vagy szakmai tárgyból? ",
				"Igényed lenne egy olyan magántanárra, aki mindenben tud segíteni neked, meghallgat, és türelmesen válaszol a kérdéseidre? ",
				"Lenne kedved magánórákat venni egy olyan magántanártól, aki sok éve csak és kizárólag azzal foglalkozik, hogy megértsd a tananyagot? ",
				"Minden álmod magánórákat venni kötetlenül úgy, hogy ráadásul nincs semmilyen félnivalód attól, hogy nem fogod megérteni amit kell? "
			],
			[
					"Szükséged lenne korrepetálásra, akár több különböző tantárgyból is, beleértve a biológiát, kémiát, matematikát? ",
					"Szeretnél korrepetálást kérni olyan tantárgyakból, mint például a fizika, matematika, angol és a kémia? ",
					"Szeretnél matematikából és angolból korrepetálást kérni úgy, hogy közben csak úgy telik az idő? ",
					"Szeretnéd angolból korrepetáltatni a tudásod úgy, hogy gyakorlatilag semmilyen kockázatot nem vállalsz? ",
					"Szükséged lenne arra, hogy felhozd a tudásod egy picit angolból, vagy hogy gyakorolj, beleértve a kiejtést, levélírást is?",
					"Szükséged lenne arra, hogy valaki gagyába rázzon téged matekból, de úgy érzed, hogy nem elég az, amit a suliban megtanultál?",
					"Úgy érzed, nem elég mély az angol tudásod, és szeretnéd egy picit mélyíteni még?",
					"Azon a véleményen vagy, hogy ráférne még egy kis csiszolás az angol tudásodra? ",
					"Úgy érzed, hogy angolból lenne még mit fejlődni, de nem tudod, hogy hogyan kezdhetnél neki? "
			],
			[
				"Én segítek neked! Kedvezményes árakon vállalok korrepetálást, ZH-ha, vizsgára való felkészítést, gyakorlatilag minden korosztálynak! ",
				"Kérj segítséget tőlem! Nekem hatalmas gyakorlatom van a magánoktatásban, és magán korrepetálásban. ",
				"Nyugodtan keress engem magántanítással, és magán oktatással. Nálam gyakoriatilag biztos, hogy meg fogod szeretni az adott tantárgyat!  ",
				"Ne habozz, keress engem, én tudok neked segíteni! "
			],
			[
				"Gyakoriatilag minden korosztályban van gyakorlatom abban, hogy hogyan lehet megszerettetni valakivel a különféle tantárgyakat. ",
				"Legyél bármilyen korosztályból, én fogok tudni Neked segíteni abban, hogy megszeresd az adott tárgyat, és kihívásra lelj. ",
				"Nem számít, hogy hány éves vagy, nálam meg fogod szeretni a tanulást és a küzdeni vágyásod is hatalmasat fog ugrani. ",
				"Nálam nem fontos, hogy hány éves vagy. Egészen kisiskolás kortól a nagy korosztályig segítek mindenkinek, akinek szüksége van rá! ",
				"Egészen első osztályos kortól a felnőttig mindenkinek segítek abban, hogy megszeresse a tanulást, és meg is értse, amire szüksége lenne. "
			],
			[
				"Ha úgy érzed, felkeltettem a figyelmed, akkor ne habozz, keress bátran, én tudok Neked segíteni mindenben! ",
				"Amennyiben úgy gondolod, hogy tudnánk együtt tanulni, akkor ne habozz! Én segítek neked mindenben! ",
				"Ha úgy véled, hogy szimpatikus vagyok neked, akkor keress engem, és segítek neked abban, hogy megszeresd a tanulást. ",
				"Amennyiben úgy gondolod, hogy tudnánk együtt tanulni, akkor keress engem bátran, ne habozz! "
			],
			[
				"A megjelölt e-mail címemen vagy telefonszámomon elérhetsz. ",
				"Ha szeretnél, akkor keress nyugodtan telefonon. ",
				"Ha szeretnéd, akkor keress meg emailben, ne itt küldj üzenetet! ",
				"Ha lenne kedved hozzá, keress meg telefonon. ",
				"Ha lenne kedved hozzá, írj egy emailt és megbeszéljük a részleteket. ",
				"Ha szeretnél, dobj egy emailt a megadott címre, és beszélgessünk egy jót! ",
				"Ha úgy érzed, akkor keress bátran e-mailen, és megbeszéljük a részleteket! ",
			]	
	];

	$names = [
		[
			"Kiss ",
			"Nagy ",
			"Szász ",
			"Kocsis ",
			"Zsuk ",
			"Zsóka ",
			"Tamási ",
			"Grőb ",
			"Veréb ",
			"Szalontai ",
			"Pelikán ",
			"Vörös ",
			"Toldi ",
			"Kovács ",
			"Gajdán ",
			"Molnár ",
			"Farkas ",
			"Somogyi ",
			"Bordás ",
			"Szécsényi ",
			"Tóth ",
			"Major ",
			"Varga ",
			"Pécz ",
			"Holik ",
			"Holcsik ",
			"Pócsik "
		],
		[
			"Jani",
			"Feri",
			"Balázs",
			"Tomi",
			"Peti",
			"Lázár",
			"Gábor",
			"Pál",
			"Norbi",
			"Géza",
			"Ottó",
			"Andor",
			"Bazsi",
			"Emese",
			"Ági",
			"Éva",
			"Márti",
			"Beáta",
			"Laura",
			"Jaffa",
			"Bori",
			"Fanni",
			"Blanka",
			"Magdolna"
		]
	];

	$emails = [
		[
			"dsx450",
			"zsuzsu530",
			"veci682",
			"petyi621",
			"tanulj44",
			"kepezz23",
			"munkalodj",
			"pallerozz",
			"erosodj",
			"tanuldmeg",
			"erosodjmeg",
			'haha',
			'kepessegek',
			'erofitoktatas',
			'tanulasezerrel',
			'edukaldmagad'
		],
		[
			"@gmail.com",
			"@freemail.hu",
			"@citromail.hu",
			"@tanulj.hu",
			"@yahoo.com",
			"@hotmail.com",
			"@aol.com",
			"@msn.com",
			"@orange.fr",
			"@live.com",
			"@outlook.com",
			"@hotmail.it",
			"@verizon.net",
			"@telenet.be",
			"@misippc.be",
			"@telenet.hu",
			"@haha.hu",
		]
	];

	$onlineTeachingArr = [
		0,1
	];

	$hourPriceArr = [
		"4000 Ft / óra",
		"6000 Ft / óra",
		"4000 - 6000 Ft / óra",
		"3000 Ft óránként",
		"3500 Ft óránként",
		"2000 Ft óránként",
		"2500-3000 Ft óránként"
	];

	$graduateArr = [
		NULL,
		NULL,
		NULL,
		"Angol tanár diplomával",
		"Német tanár diplomával",
		"Szakfordító",
		"Matematika tanár diplomával"
	];

	$businessHoursArr = [
		NULL,
		NULL,
		NULL,
		"Szerda vagy kedd esténként",
		"Péntek reggeltől kedd reggelig",
		"Bármikor megfelel",
		"Hétvégén délután",
		"Hétvékén akármikor"
	];

	$personalWebsiteArr = [
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		"tanuljvelem.hu",
		"tanuljunkegyutt.hu",
		"keszuljunk.hu",
		"keszuljunkegyutt.hu",
		"keszules.hu"
	];

	$groupTeachingArr = [
		NULL,
		NULL,
		"2-4 főt",
		"nem vállalok",
		"akárhány főt"
	];

	$subscriptionDurationArr = [
		6,12
	];

	$isGoingToHouseArr = [
		0,1
	];

	$datesArr = [
		"2021-09-31",
		"2021-10-20",
		"2021-11-25",
		"2021-12-20",
		"2021-09-20",
		"2021-10-15",
		"2021-12-23",
		"2021-10-12",
		"2021-11-16",
	];

	$datesArrWithNull = [
		"2021-09-26",
		"2021-10-24",
		"2021-11-23",
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
		NULL,
	];

	$isPublishedArr = [
		0,
		1,
		1,
		1,
		1,
		1,
		1
	];

	User::truncate();

	for($i=0;$i<15;$i++){
		$email = generateSingleStringFromMultiArray($emails);

		$phone = generatePhoneNumber();

		$description = generateSingleStringFromMultiArray($sentences);

		$description = addContactToDescription($description, $email, $phone);

		//dd($description);
		$excerpt = str_limit($description,300);

		$fullName = generateSingleStringFromMultiArray($names);

		$is_online_teaching = generateSingleItemFromArray($onlineTeachingArr);

		$hour_price = generateSingleItemFromArray($hourPriceArr);

		$graduate = generateSingleItemFromArray($graduateArr);

		$business_hours = generateSingleItemFromArray($businessHoursArr);

		$is_going_to_house = generateSingleItemFromArray($isGoingToHouseArr);

		$active_until = generateSingleItemFromArray($datesArr);

		$alap_kiemelt_until = generateSingleItemFromArray($datesArrWithNull);

		$extran_kiemelt_until = generateSingleItemFromArray($datesArrWithNull);

		$subscription_duration = generateSingleItemFromArray($subscriptionDurationArr);
		
		$personal_website = generateSingleItemFromArray($personalWebsiteArr);

		$group_teaching = generateSingleItemFromArray($groupTeachingArr);

		$is_published = generateSingleItemFromArray($isPublishedArr);

		//addCoverImageToUser($user); 

		//$user->avatar()->add($file);

		//dd($introduction,$fullName,$email);
	
		$password = Hash::make('petipali');

		$user = new User();

		$user = Auth::register([
		    'name' => $fullName,
		    'slug' => str_slug($fullName),
		    'email' => $email,
		    'phone' => $phone,
		    'hour_price' => $hour_price,
		    'password' => "petipali",
		    'password_confirmation' => "petipali",
		    'is_going_to_house' => $is_going_to_house,
		    'personal_website' => $personal_website,
		    'group_teaching' => $group_teaching,
		    'description' => $description,
		    'excerpt' => $excerpt,
		    'graduate' => $graduate,
		    'business_hours' => $business_hours,
		    'is_online_teaching' => $is_online_teaching,
		    'active_until' => $active_until,
		    'is_published' => $is_published,
		    'is_activated' => 1,
		    'subscription_duration' => $subscription_duration,
		    'alap_kiemelt_until' => $alap_kiemelt_until,
		    'extran_kiemelt_until' => $extran_kiemelt_until
		]);

		//$user->save();

		addCoverImageToUser($user);

		$subjects = Subject::inRandomOrder()->limit(3)->get();

		$cities = City::inRandomOrder()->limit(2)->get();

		//dd($subjects,$cities);

		$user->cities()->syncWithoutDetaching($cities);

		foreach($subjects as $subject){
			$num = rand(1,10);

			if($num < 3 && $alap_kiemelt_until){
				$user->subjects()->syncWithoutDetaching($subject,["alap_kiemelt_until" => $alap_kiemelt_until]);
			} else{
				$user->subjects()->syncWithoutDetaching($subject);
			}
		}

		//dd($user);

	}

});

function addCoverImageToUser($user){
	$images = [
		"img_1.jpg",
		"img_2.jpg",
		"img_3.jpg",
		"img_4.jpg",
		"img_5.jpg",
		"img_6.jpg",
		"img_7.jpg",
		"img_8.jpg",
		"img_9.jpg",
		"alap_avatar.png"
	]; 

	$baseImagePath = "http://mobil-hazam.hu/";

	$file = new File;
	$image = $images[array_rand($images)];

	$file->fromUrl($baseImagePath.$image);

	$user->avatar()->add($file);

	return true;
}