<?php
namespace Dic\Container\HTTP;

class Request
{
    /** */
    public string $controllerName;
    /**
     * get request type method
     * @return string
     */
    public function method():string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    /**
     * get path of Request URI
     * @return string
     */
    public function path():string
    {
        $path = $_SERVER["REQUEST_URI"] ?? '/';

        return str_contains($path, '?') ? explode('?', $path)[0] : $path;
    }

    /**
     * get options after "?" of Request URI
     * @return bool|null|string[]
     */
    public function options():bool|null|array
    {
        $path = $_SERVER["REQUEST_URI"] ?? '/';
        $option = str_contains($path, '?') ? explode('?', $path)[1] : null;

        if(!is_null($option)){
            
            $list = str_contains($option, '=') ? explode('=', $option): null;
            return $list;
        }

        return null;
    }
}