<?php

class helper 
{
	private function __construct
	(){}
	private function __clone(){}
	public static function getheader($title, $file = 'header')
	{
		$path = 'includes/layouts/'.$file.'.php';
		if(is_file($path)){
			return require_once $path;
		}
		return false;
	}


	public static function getFooter($file = 'footer')
	{
		$path = 'includes/layouts/'.$file.'.php';
		if(is_file($path)){
			return require_once $path;
		}
		return false;
	}
}