<?php

class Task
{
	public function __construct()
	{
		$server = new swoole_server("127.0.0.1", 9503);

		$server->on('connect', [$this, 'onConnect']);
		$server->on('receive', [$this, 'onReceive']);
		$server->on('close', [$this, 'onClose']);
		$server->start();
	}

	public function onConnect($server, $fd)
	{
		echo "connection open: {$fd}\n";
	}

	public function onReceive($server, $fd, $reactor_id, $data)
	{
		$server->send($fd, "Swoole: {$data}");
		$server->close($fd);
	}

	public function onClose($server, $fd)
	{
		echo "connection close: {$fd}\n";
	}
}