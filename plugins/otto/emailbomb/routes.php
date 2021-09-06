<?php 
use Otto\Emailbomb\Models\MailBombs;
use Maatwebsite\Excel\Concerns\ToModel;
//use Vdomah\Excel\Classes\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Rainlab\User\Models\User;
use Illuminate\Support\Facades\Mail;

Route::get("/email-bomba-dss564ete",function(){

	//$clients = MailBombs::inRandomOrder()->where("is_mail_sent",0)->take(25)->get();
	//$clients = User::where("email","viharos.otto@gmail.com")->get();

	//dd($clients);

	foreach($clients as $client){
		$vars = [
			"subject" => "Magántanár kereső",
			"name" => trim($client->name),
			"email" => trim($client->email),
			"regards" => env("APP_REGARDS"),
			"app_name" => env("APP_NAME"),
		];

		$isRegistered = User::where("email",$client->email)->exists();

		if(!$isRegistered){
			Mail::send('otto.emailbomb::mail.emailbomb', $vars, function($message) use($vars) {
			    $message->to($vars["email"]);
			    $message->subject("Új magántanár kereső weboldal");
			});
		}


		$client->is_mail_sent = 1;
		$client->save();
	}

	dd($clients);
});

Route::post("/5345b35345kfjsdfs",function(){
	/*$file = request()->file('my_excel_file');
	$clientsFromExcel = Excel::toCollection(new helperExportClass, $file);

	foreach($clientsFromExcel[0] as $client){

		if(filter_var(trim($client[1]), FILTER_VALIDATE_EMAIL)){
			//dd($client);
			$newClient = new MailBombs;

			$newClient->name = $client[0];
			$newClient->email = $client[1];
			$newClient->save();
		}
	}

	dd("Vége! :D");*/
});

class helperExportClass implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
      return 1;

        return new User([
           'name'     => $row[0],
           'email'    => $row[1],
           'password' => Hash::make($row[2]),
        ]);
    }
}