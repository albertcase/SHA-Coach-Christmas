<?php

define("TEST", TRUE); //test enviroment setting
define("TEMPLATE_ROOT", dirname(__FILE__) . '/../template/');

//Database config info
define("DBHOST", '127.0.0.1');
define("DBUSER", 'root');
define("DBPASS", '');
define("DBNAME", 'coach_christmas');

//Curio Wechat info
define("CURIO_WXID", '3736f002c80bf8bfe5aa9ad41c87c984');
define("CURIO_TOKEN", '08ecb2077e158fd621a1f175e22442e8');
define("CURIO_AUTH_URL", 'http://oauth.curio.im/v1/wx/web/auth/6d049ca8-05fb-405c-af9f-6073e172c9e9');

//Redis config info
define("REDIS_HOST", '127.0.0.1');
define("REDIS_PORT", '6379');

function __autoload($class_name) {
    if(file_exists(dirname(__FILE__) . '/../lib/' . $class_name . '.php')) 
    	require_once dirname(__FILE__) . '/../lib/' . $class_name . '.php';
}

?>
