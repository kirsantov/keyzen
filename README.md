keyzen
======

PHP Lite Framework

### Начало работы

The most basic example is including the routing module and defining a few endpoints and providing a callback function that executes when someone requests that page.

    KeyZ\App::init('config/config.php');
	KeyZ\App::run();
    
    function home() {
        echo 'You are at the home page';
    }

    function contactUs() {
        echo 'Send us an email at <a href="mailto:foo@bar.com">foo@bar.com</a>';
    }

