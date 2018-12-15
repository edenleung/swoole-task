<?php

class Task
{
	public function __construct()
	{
		$server = new swoole_server("127.0.0.1", 9503);

		$server->set([
			"task_worker_num" => 40
		]);

		$server->on('connect', [$this, 'onConnect']);
		$server->on('receive', [$this, 'onReceive']);
		$server->on('task', [$this, 'onTask']);
		$server->on('finish', [$this, 'onFinish']);
		$server->on('close', [$this, 'onClose']);
		
		$server->start();
	}

	public function onConnect($server, $fd)
	{
		echo "connection open: {$fd}\n";
	}

	public function onReceive($server, $fd, $reactor_id, $data)
	{
		$server->task($data);
		$server->send($fd, "Swoole: {$data}");
		$server->close($fd);
	}

	public function onTask($server, $task_id, $reactor_id, $data)
	{
		require_once '../autoload.php';
		$data = json_decode($data, true);
		$task = $data['task'];
		$method = $data['method'];
		$msg = $data['msg'];

		return call_user_func($task . '::' . $method, $msg);
	}

	public function onFinish($server, $task_id, $data)
	{
		echo 'finish:' . $data . "\n";
	}

	public function onClose($server, $fd)
	{
		echo "connection close: {$fd}\n";
	}
}

new Task();