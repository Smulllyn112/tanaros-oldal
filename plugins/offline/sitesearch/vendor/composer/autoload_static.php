<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit749947d0ec4a04607bd4dbe4652a1bfa
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit749947d0ec4a04607bd4dbe4652a1bfa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit749947d0ec4a04607bd4dbe4652a1bfa::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}