<?php 
use Otto\Personfinder\Models\Subject;



    //Optional error riporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    //Import config data
    require_once 'plugins/otto/personfinder/assets/src/config.php';

    //Import SimplePayment class
    require_once 'plugins/otto/personfinder/assets/src/SimplePayV21.php';

    $trx = new SimplePayBack;

    $trx->addConfig($config);

    $this["user"] = Auth::getUser();


    //result
    //-----------------------------------------------------------------------------------------
    $this['result'] = array();
    if (isset($_REQUEST['r']) && isset($_REQUEST['s'])) {
        if ($trx->isBackSignatureCheck($_REQUEST['r'], $_REQUEST['s'])) {
            $this['result'] = $trx->getRawNotification();
        }
    }

    //dd($this['result']);



    if($this['result']["e"] === "SUCCESS"){
    	$simplepay_session = json_decode($this["user"]->simplepay_session);

    	$this["pay_type"] = $simplepay_session->type;
    	$this["price"] = $simplepay_session->price;

    	if($this["pay_type"] == "register"){
    		$this["user"]->active_until = $simplepay_session->active_until;
    		$this["user"]->save();

    		$this["invoice_message"] = "Sikeres előfizetés a ". env("APP_NAME") . "alkalmazásban!";
    	} elseif($this["pay_type"] == "extra_kiemeles"){
    		$this["user"]->extran_kiemelt_until = $simplepay_session->active_until;
    		$this["user"]->save();

    		$this["invoice_message"] = "Sikeres extra kiemelés előfiezés a ". env("APP_NAME") . "alkalmazásban!";
    	}elseif($this["pay_type"] == "alap_kiemeles"){
    		$this["user"]->alap_kiemelt_until = $simplepay_session->active_until;
    		$this["user"]->save();

    		$this["subject"] = Subject::find($simplepay_session->subject_id);

    		foreach($this["user"]->subjects as $subject){
    			if($subject->id == $this["subject"]->id){
    				$subject->pivot->alap_kiemelt_until = $simplepay_session->active_until; 
    				$subject->pivot->save();

    				//dd($subject,$this["user"],$simplepay_session->active_until);
    			}
    		}

    		$this["invoice_message"] = "Sikeres extra kiemelés előfiezés a ". env("APP_NAME") . "alkalmazásban!";
    	}


    	$this["user"]->simplepay_session = null;
    	
    	//$this["user"]->save();

        //az invoice elkészítése 
        require_once("plugins/otto/personfinder/assets/billingo/create_invoice.php");

       try {
            $invoice_url = createInvoice([
                "megjegyzes" => $this["invoice_message"],
                "osszeg" => $this["price"],

                "client_name" => $this["user"]->name,
                "client_email" => $this["user"]->email,
                "client_country" => $this["user"]->billing_country,
                "client_city" => $this["user"]->billing_city,
                "client_postal_code" => $this["user"]->billing_zip,
                "client_street_name" => $this["user"]->billing_street,
            ]);

        } catch (JSONParseExceptionAlias $e) {
            echo "Error parsing response";
        } catch (RequestErrorExceptionAlias $e) {
            echo "Error in request";
        } catch (GuzzleException $e) {
            var_dump($e->getMessage());
        }
        
        


}




