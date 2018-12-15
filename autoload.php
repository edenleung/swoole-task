<?php

function __autoload($name)
{
	$class = '../tasks/' . $name . '.php';
	if (!file_exists($class)) {
		throw new \Exception("Class: {$name} not found!\n");
	}

	require_once $class;
}