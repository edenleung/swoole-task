<?php
require '../vendor/autoload.php';

use xiaodi\Channel\Client;

class Http
{
	protected $server = null;

	public function __construct()
	{
		$this->server = new swoole_http_server("0.0.0.0", 9501);
		$this->server->on("start", [$this, 'onStart']);
		$this->server->on("request", [$this, 'onRequest']);
		$this->server->start();
	}

	public function onStart($server)
	{
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
			$method = $data['method'];
			// 附带参数
			$msg = $data['msg'];

			// 提供了TCP和UDP传输协议Socket客户端的封装代码，使用时仅需new Swoole\Coroutine\Client即可。
			$client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);

			// 连接到远程服务器
			if (!$client->connect('127.0.0.1', 9503, 0.5)) {
				throw new \Exception("connect failed. Error: {$client->errCode}\n");
			}

			// 发送数据
			$client->send(json_encode(['task' => $task, 'method' => $method,  'msg' => $msg]));
			echo $client->recv();
			return;
		}

		$response->end('error');
	}
}

$server = new Http();




