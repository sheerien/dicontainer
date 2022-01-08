<?php
namespace Dic\Container\HTTP;

use Dic\Container\View\View;


class Route
{
    /**
     * Array Of Routes
     * @var array $routes
     */
    public static array $routes=[];

    /**
     * $request obj from Request 
     * @var Request $request
     */
    public Request $request;

    /**
     * $response obj from Response
     * @var Response $response
     */
    public Response $response;

    /**
     * Route Constructor
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response) 
    {
	    $this->request = $request;
	    $this->response = $response;
	}

    /**
     * get method
     * @param mixed $route
     * @param mixed $action
     * @return void
    */

    public static function get($route, $action)
    {
        self::$routes['get'][$route] = $action;
    }

    /**
     * post method
     * @param mixed $route
     * @param mixed $action
     * @return void
     */
    public static function post($route, $action)
    {
        self::$routes['post'][$route] = $action;
    }

    /**
     *  put method
     * @param mixed $route
     * @param mixed $action
     * @return void
     */
    public static function put($route, $action)
    {
        self::$routes['put'][$route] = $action;
    }

    /**
     * delete method
     * @param mixed $route
     * @param mixed $action
     * @return void
     */
    public static function delete($route, $action)
    {
        self::$routes['delete'][$route] = $action;
    }

    /**
     * resolve route 
     * @return void
     */
    public function resolve()
    {   
        /**
         * get type request method
         * @var string $method 
         */
        $method = $this->request->method();
        /**
         * get path from request $_SERVER["REQUEST_URI"]
         * @var string $path
         */
        $path = $this->request->path();

        /**
         * fetch from array $routes this method and the path 
         * if not exist assignment false value
         * @var mixed $action
         */
        $action = self::$routes[$method][$path] ?? false;
        // 404 handler
        // array_key_exists($path, self::$routes[$method])
        if(! $action){
            View::makeError('404');
        }

        /**
         * Handler Route is A Callback Function 
         */
        if(is_callable($action)){
            call_user_func_array($action, [$this->request->options()]);
        }

        /**
         * Handler Route is An Array
         */
        if(is_array($action)){
            call_user_func_array([new $action[0], $action[1]], [$this->request->options()]);
        }


        // if(is_string($action)){
        //     $action = str_contains($action, '@') ? explode('@', $action) : new \Exception("string should be contain [ @ ] in between controller class and method");

        //     if(is_array($action)){
            
        //         call_user_func_array([ $action[0], $action[1]], [$this->request->options()]);
        //     }
        // }
    }

}