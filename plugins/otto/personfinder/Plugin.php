<?php namespace Otto\Personfinder;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            "Otto\Personfinder\Components\Register" => "register_form",
            "Otto\Personfinder\Components\Login" => "login_form",
            "Otto\Personfinder\Components\ContactTeacher" => "contact_teacher"
        ];         	
    }

    public function registerSettings()
    {
    }
}
