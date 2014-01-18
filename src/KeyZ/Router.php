<?php
/**
 * Created by PhpStorm.
 * User: anatoliykirsantov
 * Date: 04.01.14
 * Time: 0:27
 */

namespace KeyZ;

class Router extends App {
    public static $routes;

    public function load($routes) {
        self::$routes = $routes;
    }

    public function get() {

        $path = str_replace(
            array('%2F', '%26', '%23', '//','%28','%29'),
            array('/', '%2526', '%2523', '/%252F','(',')'),
            rawurlencode($_GET['path'])
        );

        if (substr($path,-1)=='/') {
            $path=substr($path,0,-1);
        }
        foreach(self::$routes as $base_template=>$routes) {
            foreach ($routes as $pattern) {
                $prefix = (strpos('@',$pattern['re'])!==FALSE) ? '/' : '@';
                $p = sprintf('%s%s%s',$prefix,$pattern['re'],$prefix);
                $match = preg_match($p,$path,$matches,PREG_OFFSET_CAPTURE);
                if ($match) {
                    $view = explode('/',$pattern['view']);

                    // Если после слеша не указан метод, запускаем метод default
                    if (!isset($view[1])) {
                        $view[1] = 'default';
                    }
                    array_shift($matches);

                    foreach($matches as $item){
                        $params[] = $item[0];
                    }

                    parent::$template = $base_template;

                    return array(
                        'class'=>$view[0],
                        'method'=>$view[1],
                        'params'=>$params
                    );
                }
            }
        }
        return false;
    }
}
