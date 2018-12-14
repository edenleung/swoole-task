<?php
require '../vendor/autoload.php';

use xiaodi\Channel\Client;

class Http
{
	protected $server = null;

	public function __construct()
	{
		$this->server = new swoole_http_server("0.0.0.0", 9503);
		$this->server->on("start", [$this, 'onStart']);
		$this->server->on("request", [$this, 'onRequest']);
		$this->server->start();
	}

	public function onStart($server) {
		echo "Swoole http server is started at http://127.0.0.1:9503\n";
	}

	public function onRequest($request, $response)
	{
		$response->header("Content-Type", "text/plain");

		if ($request->server['path_info'] === '/favicon.ico') {
			return $response->end();
		}

		$data = $request->get;
		if (!empty($data)) {

			$response->end('success');

			// 任务名称
			$task = $data['task'];
			// 附带参数
			$msg = $data['msg'];
			return;
		}

		$response->end('error');
	}
}

$server = new Http();

