<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit94ce7cddb3b6fe7222a3db85685496a7
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit94ce7cddb3b6fe7222a3db85685496a7', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit94ce7cddb3b6fe7222a3db85685496a7', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit94ce7cddb3b6fe7222a3db85685496a7::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
