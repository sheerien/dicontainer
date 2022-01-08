<?php

use Dic\Container\Bootstrap\App;


class Application
{
    /**
     * Application Constructor
     */
    private function __construct() {}
    
    /**
     * run the application
     * 
     * @return void
     */
    public static function run()
    {
        /**
         * Define root path
         */
        define('ROOT', realpath(__DIR__ . '/..'));
        
        /**
         * Define Directory Separator
         */
        define('DS', DIRECTORY_SEPARATOR);
        // $app = new App();
        app();
        app()->run();
        // App::run();
    }
}