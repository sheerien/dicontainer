<?php
namespace Dic\Container\Bootstrap;

use Dic\Container\HTTP\Route;
use Dic\Container\HTTP\Request;
use Dic\Container\HTTP\Response;
use Dic\Container\Utilities\Whoops;
use Dic\Container\Foundations\Container;


class App
{
    private static Container $container;
    protected Request $request;

    protected Response $response;

    protected Route $route;

    public function __construct()
    {
        static::$container = new Container();
        static::$container->set(Request::class, fn()=> new Request); 
        static::$container->set(Response::class, fn()=> new Response); 
        static::$container->set(Route::class, function(Container $c){
            return new Route($c->get(Request::class), $c->get(Response::class));
        });
    }
    public function boot()
    {
        static::$container->get(Route::class)->resolve();
        // $this->route->resolve();
    }
    /**
     * Run The Application.
     * 
     * @return void
     */
    public  function run(){
        //Exception Handler
        Whoops::handle();

        $this->boot();

        // $route = new Route(new Request, new Response);
        d('this is app test');
        dd(static::$container->get(Route::class)->request->method());
        // dd($this->route->request->method());
    }
}

?>