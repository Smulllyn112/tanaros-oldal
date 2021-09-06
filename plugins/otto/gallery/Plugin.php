<?php namespace Otto\Gallery;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            "Otto\Gallery\Components\Gallery" => "gallery",
        ];        
    }

    public function registerSettings()
    {
    }
}
