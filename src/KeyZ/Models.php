<?php
/**
 * Created by PhpStorm.
 * User: anatoliykirsantov
 * Date: 04.01.14
 * Time: 4:06
 */

namespace KeyZ;

use ActiveRecord;
/**
 * Class Models
 * @package KeyZ
 * Для работы класса нужен пакет php-activerecord/php-activerecord
 */
class Models extends App {
    //

    public function connect() {
        $connections = array();
        foreach (parent::$databases as $name=>$db) {
            $connections[$name]=App::dbConn($name);
        }
        ActiveRecord\Config::initialize(function($cfg) use ($connections) {
            $cfg->set_model_directory('models');
            $cfg->set_connections($connections);
            # default connection is first
            $cfg->set_default_connection(key($connections));
        });


    }

} 