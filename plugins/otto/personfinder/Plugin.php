<?php namespace Otto\Personfinder;

use Otto\Personfinder\Console\Recurring;
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

    public function register()
    {
        $this->registerConsoleCommand('simplepay.recurring', Recurring::class);
    }
}
