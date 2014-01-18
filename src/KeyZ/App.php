<?php
/**
 * Created by PhpStorm.
 * User: anatoliykirsantov
 * Date: 03.01.14
 * Time: 17:28
 */

namespace KeyZ;

/**
 * Class App
 * @package KeyZ
 */
class App {
    public static $id;
    public static $description;
    public static $host;
    public static $secret;
    public static $template = 'base';
    public static $layout;
    public static $api;
    /**
     * @var databases - можно подключать несколько баз данных
     */
    public static $databases = array();
    //private $router;
    /**
     * Autoloader constructor.
     *
     * @param string $baseDir Purl library base directory (default: dirname(__FILE__).'/..')
     */
    public function init($config)
    {
        require_once($config);
        $conf = get_conf();
        if (!$conf['routes']) {
            printf("<b>Error:</b> Routes parametr not found in - %s",$config);
            exit();
        }

        if ($conf) {
            foreach ($conf as $key=>$data) {
                switch ($key) {
                    case 'routes':
                        if ($data) {
                            Router::load($data);
                        }
                        break;
                    case 'id':
                    case 'description':
                    case 'host':
                    case 'secret':
                    case 'databases':
                    case 'api':
                        self::$$key=$data;
                        break;
                    // Reserved parametres
                    case 'path':
                    // Wrong parametres
                    default:
                        printf("<b>Error:</b> Wrong config parametr - %s",$key);
                        exit();
                }
            }
        } else {
            printf("<b>Error:</b> Config file not found or wrong format");
            exit();

        }
    }

    public function run() {
        $response = Router::get();

        if (is_array($response)) {

            $Class = $response['class'];
            $method = $response['method'];

            require_once($_SERVER['DOCUMENT_ROOT'].'/views/'.$Class.'.php');
            $Class = sprintf('\KeyZ\%s',$Class);

            Models::connect();
            Session::start();
            // Запускаем обработчик запроса и получаем от него данные для отображения
            // Выводим данные на экран через шаблонизатор
            Views::display(
                $Class::$method($response['params'])
            );
        } else {
            printf("<b>Error 404:</b> Page not found");
            exit();
        }

    }

    public function setLayout($layout) {
        self::$layout = $layout;
    }

    public function dbConn($db_name) {
        return sprintf('%s://%s:%s@%s/%s',
            self::$databases[$db_name]['type'],
            self::$databases[$db_name]['user'],
            self::$databases[$db_name]['pass'],
            self::$databases[$db_name]['host'],
            $db_name
        );
    }

    public function getSecretKey() {
        return self::$secret;
    }
} 