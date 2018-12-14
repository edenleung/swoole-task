<?php

require './vendor/autoload.php';
use xiaodi\Channel\Client;

$server = new swoole_websocket_server("0.0.0.0", 9502);

$server->on('open', function ($server, $req) {
});

$server->on('message', function ($server, $frame) {
});

$server->on('close', function ($server, $fd) {
});

$server->start();