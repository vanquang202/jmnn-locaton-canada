<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4f8ba46abd8451f1ac0138a73103f598
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'Jmnn\\LocationCa\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Jmnn\\LocationCa\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4f8ba46abd8451f1ac0138a73103f598::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4f8ba46abd8451f1ac0138a73103f598::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4f8ba46abd8451f1ac0138a73103f598::$classMap;

        }, null, ClassLoader::class);
    }
}