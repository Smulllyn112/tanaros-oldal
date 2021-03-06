<?php

use Otto\Personfinder\Models\City;

use Otto\Personfinder\Models\Subject;

use Otto\Personfinder\Models\Subscription;
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



	return Redirect::to("/lemondas");

})->middleware("web");

//recurring
Route::get("/23423842hfbskdfs242342",function(){

    $date = Carbon::now();

    $subscriptions = Subscription::where('status_id', 2)
        ->whereDate('recurring_next_billing_date', $date->format('Y-m-d'))
        ->whereDate('recurring_final_payment_date', '>', $date->format('Y-m-d'))
        ->get();

    $subscriptions->each(function (Subscription $subscription) {
        (new \Otto\Personfinder\Classes\Recurring())->process($subscription);
    });

})->middleware("web");



Route::get("/extra-kiemeles",function(){

	$user = Auth::getUser();


	$simplepay_options = [

		"price" => City::$extraKiemelesEgyHonapra,

		"type" => "extra_kiemeles",

		"active_until" => Carbon::now()->addMonths(1)->format('Y-m-d'),

	];



	//dd($user);



	$user->simplepay_session = json_encode($simplepay_options);

	$user->save();

	return Redirect::to("/fizetes");

	//return Redirect::to("/egyszeri-fizetes");

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


	//return Redirect::to("/egyszeri-fizetes");

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



	dd("V??ge! :D");

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

		"anal??zis",

		"matematika - ??ltal??nos iskola",

		"matematika - gimn??zium",

		"matematika - egyetem",

		"gazdas??gi matematika",

		"line??ris algebra",

		"oper??ci??kutat??s",

		"statisztika",



		"angol",

		"francia",

		"n??met",

		"holland",

		"spanyol",

		"latin",

		"lengyel",



		"f??ldrajz",

		"t??rt??nelem",

		"etika",

		"szociol??gia",



		"irodalom",

		"magyar",

		"magyar k??lf??ldieknek",

		"verselemz??s",

		"essz?? ??r??s",

		"t??rsadalomismeret",



		"testnevel??s",

		"kos??rlabda",

		"??sz??s",

		"foci",

		"tennisz",



		"fizika",

		"h??tan",

		"m??szaki rajz",

		"g??pelemek",

		"??br??zol?? geometria",

		"AutoCad",

		"elektronika",

		"elektrotechnika",

		"jelek ??s rendszerek",

		"rezg??stan",

		"statika",



		"tanul??sm??dszertan",

		"besz??dtechnika",



		"biol??gia",

		"k??mia",

		"biok??mia",

		"k??rnyezetismeret",

		"term??szetismeret",



		"rajz",

		"m??v??szett??rt??net",





		"marketing",

		"k??zgazdas??gtan",

		"makro??kon??mia",

		"mikro??kon??mia",

		"p??nz??gy",

		"sz??mvitel",



		"jogi ismeretek",



		"informatika",

		"access",

		"excel",

		"adatb??ziskezel??s",



		"zene",

		"basszusgit??r",

		"dobol??s",

		"furulya",

		"fuvola",

		"heged??",

		"csell??",

		"szolf??zs",

		"zeneelm??let",

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

			$introduction = $introduction . " Az el??rhet??s??geim: $email, $phone";

		} elseif($num < 5){

			$introduction = $introduction . " Keress b??tran: $email, $phone";

		} elseif($num < 7){

			$introduction = $introduction . " Itt el??rhetsz: $email, $phone";

		} else {

			$introduction = $introduction . " Itt k??nnyen el??rhetsz: $email, $phone";

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



// fake userek gy??rt??sa

Route::get("/3htrzr424242",function(){

	/*	$sentences = [

			[

				"Mag??ntan??rt keresel? Olyat, akivel a tanul??s igazi j??t??k lesz, nem csup??n k??nszenved??s? ",

				"Szeretn??l ??r??kat venni egy olyan mag??ntan??rt??l, aki t??nyleg ??rdekes, ??s sz??rakoztat?? ??r??kat tart? ",

				"Sz??ks??ged lenne egy olyan mag??ntan??rra, aki a helyedbe tudja k??pzelni mag??t, ??s maxim??lisan kiseg??t mindenben? ",

				"Lenne kedved egy olyan mag??ntan??rral tanulni, aki hatalmas gyakorlattal rendelkezik tan??t??s, oktat??s ter??n? ",

				"Szeretn??l megismerni egy olyan mag??ntan??rt, aki gyakorlatilag minden k??rd??sedre tud v??laszolni a keresett t??mak??rb??l, vagy szakmai t??rgyb??l? ",

				"Ig??nyed lenne egy olyan mag??ntan??rra, aki mindenben tud seg??teni neked, meghallgat, ??s t??relmesen v??laszol a k??rd??seidre? ",

				"Lenne kedved mag??n??r??kat venni egy olyan mag??ntan??rt??l, aki sok ??ve csak ??s kiz??r??lag azzal foglalkozik, hogy meg??rtsd a tananyagot? ",

				"Minden ??lmod mag??n??r??kat venni k??tetlen??l ??gy, hogy r??ad??sul nincs semmilyen f??lnival??d att??l, hogy nem fogod meg??rteni amit kell? "

			],

			[

					"Sz??ks??ged lenne korrepet??l??sra, ak??r t??bb k??l??nb??z?? tant??rgyb??l is, bele??rtve a biol??gi??t, k??mi??t, matematik??t? ",

					"Szeretn??l korrepet??l??st k??rni olyan tant??rgyakb??l, mint p??ld??ul a fizika, matematika, angol ??s a k??mia? ",

					"Szeretn??l matematik??b??l ??s angolb??l korrepet??l??st k??rni ??gy, hogy k??zben csak ??gy telik az id??? ",

					"Szeretn??d angolb??l korrepet??ltatni a tud??sod ??gy, hogy gyakorlatilag semmilyen kock??zatot nem v??llalsz? ",

					"Sz??ks??ged lenne arra, hogy felhozd a tud??sod egy picit angolb??l, vagy hogy gyakorolj, bele??rtve a kiejt??st, lev??l??r??st is?",

					"Sz??ks??ged lenne arra, hogy valaki gagy??ba r??zzon t??ged matekb??l, de ??gy ??rzed, hogy nem el??g az, amit a suliban megtanult??l?",

					"??gy ??rzed, nem el??g m??ly az angol tud??sod, ??s szeretn??d egy picit m??ly??teni m??g?",

					"Azon a v??lem??nyen vagy, hogy r??f??rne m??g egy kis csiszol??s az angol tud??sodra? ",

					"??gy ??rzed, hogy angolb??l lenne m??g mit fejl??dni, de nem tudod, hogy hogyan kezdhetn??l neki? "

			],

			[

				"??n seg??tek neked! Kedvezm??nyes ??rakon v??llalok korrepet??l??st, ZH-ha, vizsg??ra val?? felk??sz??t??st, gyakorlatilag minden koroszt??lynak! ",

				"K??rj seg??ts??get t??lem! Nekem hatalmas gyakorlatom van a mag??noktat??sban, ??s mag??n korrepet??l??sban. ",

				"Nyugodtan keress engem mag??ntan??t??ssal, ??s mag??n oktat??ssal. N??lam gyakoriatilag biztos, hogy meg fogod szeretni az adott tant??rgyat!  ",

				"Ne habozz, keress engem, ??n tudok neked seg??teni! "

			],

			[

				"Gyakoriatilag minden koroszt??lyban van gyakorlatom abban, hogy hogyan lehet megszerettetni valakivel a k??l??nf??le tant??rgyakat. ",

				"Legy??l b??rmilyen koroszt??lyb??l, ??n fogok tudni Neked seg??teni abban, hogy megszeresd az adott t??rgyat, ??s kih??v??sra lelj. ",

				"Nem sz??m??t, hogy h??ny ??ves vagy, n??lam meg fogod szeretni a tanul??st ??s a k??zdeni v??gy??sod is hatalmasat fog ugrani. ",

				"N??lam nem fontos, hogy h??ny ??ves vagy. Eg??szen kisiskol??s kort??l a nagy koroszt??lyig seg??tek mindenkinek, akinek sz??ks??ge van r??! ",

				"Eg??szen els?? oszt??lyos kort??l a feln??ttig mindenkinek seg??tek abban, hogy megszeresse a tanul??st, ??s meg is ??rtse, amire sz??ks??ge lenne. "

			],

			[

				"Ha ??gy ??rzed, felkeltettem a figyelmed, akkor ne habozz, keress b??tran, ??n tudok Neked seg??teni mindenben! ",

				"Amennyiben ??gy gondolod, hogy tudn??nk egy??tt tanulni, akkor ne habozz! ??n seg??tek neked mindenben! ",

				"Ha ??gy v??led, hogy szimpatikus vagyok neked, akkor keress engem, ??s seg??tek neked abban, hogy megszeresd a tanul??st. ",

				"Amennyiben ??gy gondolod, hogy tudn??nk egy??tt tanulni, akkor keress engem b??tran, ne habozz! "

			],

			[

				"A megjel??lt e-mail c??memen vagy telefonsz??momon el??rhetsz. ",

				"Ha szeretn??l, akkor keress nyugodtan telefonon. ",

				"Ha szeretn??d, akkor keress meg emailben, ne itt k??ldj ??zenetet! ",

				"Ha lenne kedved hozz??, keress meg telefonon. ",

				"Ha lenne kedved hozz??, ??rj egy emailt ??s megbesz??lj??k a r??szleteket. ",

				"Ha szeretn??l, dobj egy emailt a megadott c??mre, ??s besz??lgess??nk egy j??t! ",

				"Ha ??gy ??rzed, akkor keress b??tran e-mailen, ??s megbesz??lj??k a r??szleteket! ",

			]

	];



	$names = [

		[

			"Kiss ",

			"Nagy ",

			"Sz??sz ",

			"Kocsis ",

			"Zsuk ",

			"Zs??ka ",

			"Tam??si ",

			"Gr??b ",

			"Ver??b ",

			"Szalontai ",

			"Pelik??n ",

			"V??r??s ",

			"Toldi ",

			"Kov??cs ",

			"Gajd??n ",

			"Moln??r ",

			"Farkas ",

			"Somogyi ",

			"Bord??s ",

			"Sz??cs??nyi ",

			"T??th ",

			"Major ",

			"Varga ",

			"P??cz ",

			"Holik ",

			"Holcsik ",

			"P??csik "

		],

		[

			"Jani",

			"Feri",

			"Bal??zs",

			"Tomi",

			"Peti",

			"L??z??r",

			"G??bor",

			"P??l",

			"Norbi",

			"G??za",

			"Ott??",

			"Andor",

			"Bazsi",

			"Emese",

			"??gi",

			"??va",

			"M??rti",

			"Be??ta",

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

		"4000 Ft / ??ra",

		"6000 Ft / ??ra",

		"4000 - 6000 Ft / ??ra",

		"3000 Ft ??r??nk??nt",

		"3500 Ft ??r??nk??nt",

		"2000 Ft ??r??nk??nt",

		"2500-3000 Ft ??r??nk??nt"

	];



	$graduateArr = [

		NULL,

		NULL,

		NULL,

		"Angol tan??r diplom??val",

		"N??met tan??r diplom??val",

		"Szakford??t??",

		"Matematika tan??r diplom??val"

	];



	$businessHoursArr = [

		NULL,

		NULL,

		NULL,

		"Szerda vagy kedd est??nk??nt",

		"P??ntek reggelt??l kedd reggelig",

		"B??rmikor megfelel",

		"H??tv??g??n d??lut??n",

		"H??tv??k??n ak??rmikor"

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

		"2-4 f??t",

		"nem v??llalok",

		"ak??rh??ny f??t"

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

	];*/



	//User::truncate();

	//$users = User::all();

	foreach($users as $user){
	//for($i=0;$i<15;$i++){

		/*$email = generateSingleStringFromMultiArray($emails);



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



		$is_published = generateSingleItemFromArray($isPublishedArr);*/



		//addCoverImageToUser($user);



		//$user->avatar()->add($file);



		//dd($introduction,$fullName,$email);



		//$password = Hash::make('petipali');



		/*$user = new User();



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

		]);*/



		//$user->save();



		//addCoverImageToUser($user);



		//$subjects = Subject::inRandomOrder()->limit(3)->get();



		//$cities = City::inRandomOrder()->limit(2)->get();



		//dd($subjects,$cities);



		//$user->cities()->syncWithoutDetaching($cities);



		/*foreach($subjects as $subject){

			$num = rand(1,10);



			if($num < 3 && $alap_kiemelt_until){

				$user->subjects()->syncWithoutDetaching($subject,["alap_kiemelt_until" => $alap_kiemelt_until]);

			} else{

				$user->subjects()->syncWithoutDetaching($subject);

			}

		}*/



		//dd($user);



	}



});



function addCoverImageToUser($user){

	$images = [
		"alap_avatar.png"
	];



	$baseImagePath = "http://mobil-hazam.hu/";



	$file = new File;

	$image = $images[array_rand($images)];



	$file->fromUrl($baseImagePath.$image);



	$user->avatar()->add($file);



	return true;

}
