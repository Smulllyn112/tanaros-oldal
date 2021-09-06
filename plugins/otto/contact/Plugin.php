<?php namespace Otto\Contact;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            "Otto\Contact\Components\ContactForm" => "contactform"
        ];         	
    }

    public function registerSettings()
    {
    }
}
