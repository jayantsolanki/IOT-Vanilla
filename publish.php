<?php
require(__DIR__ . '/spMQTT.class.php');

$mqtt = new spMQTT('tcp://localhost:1883/');

spMQTTDebug::Enable();

//$mqtt->setAuth('sskaje', '123123');
$connected = $mqtt->connect();
if (!$connected) {
    die("Not connected\n");
}

$mqtt->ping();

//$msg = str_repeat('1234567890', 1);

//$mqtt->publish('esp/valve', $msg, 0, 1, 0, 1);

sleep(1);

$msg = str_repeat('122', 1);

# mosquitto_sub -t 'sskaje/#'  -q 1 -h test.mosquitto.org
$mqtt->publish('esp/valve', $msg, 0, 1, 0, 1);
echo "Success";



