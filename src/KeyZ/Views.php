<?php
/**
 * Created by PhpStorm.
 * User: anatoliykirsantov
 * Date: 04.01.14
 * Time: 4:05
 */

namespace KeyZ;


class Views extends App{

    public function display($vars=array()) {
        list($dir,$file) = explode('/',self::$template);
        if (!self::$layout) {
            printf('<p><b>Error:</b> Layout not defined!</p>');
            exit;
        }
        extract($vars,EXTR_SKIP);
        //Reserved Vars
        $base_template = sprintf('%s/views/templates/%s.php',$_SERVER['DOCUMENT_ROOT'],self::$template);
        $layout = sprintf('%s/views/templates/%s/layouts/%s.php',$_SERVER['DOCUMENT_ROOT'],$dir,self::$layout);

        // Сначала загружаем файл верстки страницы, внутри которого формируются разные блоки для базового шаблона
        if (file_exists($layout)) {
            require_once($layout);
        } else {
            printf('<p><b>Error:</b> Layout file %s not found!</p>',$layout);
            exit;
        }

        // Затем загружаем базовый шаблон в котором заранее предусмотрены места для размещения блоков,
        // которые формируются в шаблоне (layout)
        if (file_exists($base_template)) {
            require_once($base_template);
        } else {
            printf('<p><b>Error:</b> Template file %s not found!</p>',$base_template);
            exit;
        }
    }

}