<?php
echo "<pre>";
echo "Сайт OTUS из контейнера\n";
echo php_sapi_name() . PHP_EOL;
$redis = new Redis();
$redis->connect('redis', 6379);
// $redis->set("test", "This is Test value for REDIS");
echo "Connection to server sucessfully";
echo "Server is running: " . $redis->ping() . "," . $redis->get("test")."\n";

$memcache = new Memcached;
$memcache->addServer("memcached", 11211);
$memcache->set('key', 'test');
$get_value = $memcache->get('key');
echo "Данные из Memcache: $get_value\n";

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

$r = [1,2,3,4,5];
echo "выведем статус сборщика мусора\n";
gc_collect_cycles();
var_dump(gc_status());
echo "что там в переменной r? \n";
xdebug_debug_zval('r');
unset($r);
echo "show r after unset: ";
xdebug_debug_zval('r');
phpinfo(8);
