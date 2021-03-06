<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit929e0a2b22ab59080a6db6be510fcec4
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit929e0a2b22ab59080a6db6be510fcec4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit929e0a2b22ab59080a6db6be510fcec4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
