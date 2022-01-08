<?php

use Dic\Container\View\View;
use Dic\Container\Bootstrap\App;

if(! function_exists('env')){
    /**
    * set key for env
    * @param mixed $key
    * @param mixed $default
    * @return mixed
    */
    function env($key, $default = null){
    
    return $_ENV[$key] ?? value($default);
    
    }
}
if(!function_exists('app')){

    /**
     * singleton method for the run of framework.
     * 
     * @return App|null
     */
    function app(){
        static $instance = null;
        if(is_null($instance)){
            $instance = new App();
        }
        return $instance;
    }
}
    
    if(! function_exists('value')){
    /**
    * set value from action routers
    * @param mixed $value
    * @return mixed
    */
    function value($value){
    
    return ($value instanceof Closure) ? $value() : $value;
    
    }
}

if(!function_exists('dd')){
    
    /**
     * dump and die
     * 
     * @param mixed $data
     * @return void
     */
    function dd($data){
        dump($data);
        die();
    }
    
}

if(!function_exists('d')){
    
    /**
     * dump
     * 
     * @param mixed $data
     * @return void
     */
    function d($data){
        dump($data);
    }
    
}

if(!function_exists('view')){
    /**
     * Summary of view
     * @param mixed $view
     * @param mixed $params
     * @return void
     */
    function view($view, $params = []){
        View::make($view, $params);
    }
}