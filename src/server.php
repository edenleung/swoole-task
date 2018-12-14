<?php
require '../vendor/autoload.php';

use xiaodi\Channel\Server;
$server = new Server('0.0.0.0', 9501);
$server->run();
