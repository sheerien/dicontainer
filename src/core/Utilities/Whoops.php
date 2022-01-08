<?php
namespace Dic\Container\Utilities;

class Whoops
{
    /**
     * Whoops Constructor.
     */
    private function __construct() {}
    
    /**
     * Handle The Whoops Exception.
     * 
     * @return void
     */
    public static function handle()
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }
}