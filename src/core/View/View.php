<?php
namespace Dic\Container\View;

use PDO;

class View
{   
    /**
     * make view
     * @param mixed $view
     * @param mixed $params
     * @return void
     */
    public static function make($view,  $params = [])
    {
        $baseContent = self::getBaseContent();
        $viewContent = self::getViewContent($view, params: $params);

        echo str_replace('{{content}}', $viewContent, $baseContent);
    }

    // handling view 404
    public static function makeError($error)
    {
        // self::getViewContent($error, true);
        d('page not found') ;
    }

    /** 
     * getBaseContent html layout
     * @return bool|string
     */
    protected static function getBaseContent()
    {
        ob_start();

        include  main_path_layout();
        
        return ob_get_clean();
    }


    /**
     * get view content
     * @param string $view
     * @param bool $isError
     * @param string $params
     * @return bool|string
     */
    protected static function getViewContent($view, $isError = false, $params = [])
    {
        $path = $isError ? error_path() : view_path();
        // var_dump($path);

        if(str_contains($view, '.')){
            $views = explode('.', $view);
            foreach($views as $view){
                if(is_dir($path . $view)){
                    $path = $path . $view . DIRECTORY_SEPARATOR;
                }
                
                $view = $path . end($views) . '.php'; 
            }
        }else{
            $view = $path . $view . '.php';
        }
        // var_dump($view);

        foreach ($params as $param => $value) {
            // $param = $value = []
            $$param = $value;
        }

        if($isError){
            /**
             * include 404 not found
             */
            include $view;
            
        } else {
            ob_start();
            /**
             * include page is exist
             */
            include $view;
            return ob_get_clean();
        }

    }
}