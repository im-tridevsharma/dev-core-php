<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3d8db722e168afd49c47f6f184aa0742
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Src\\Models\\' => 11,
            'Src\\Controllers\\' => 16,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Src\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Models',
        ),
        'Src\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Controllers',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3d8db722e168afd49c47f6f184aa0742::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3d8db722e168afd49c47f6f184aa0742::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3d8db722e168afd49c47f6f184aa0742::$classMap;

        }, null, ClassLoader::class);
    }
}