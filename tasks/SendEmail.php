<?php

class SendEmail
{
	public static function send($task_id)
	{
		sleep(rand(1, 5));
		return 'done:' . $task_id."\n";
	}
}
