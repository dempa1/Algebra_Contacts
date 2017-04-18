<?php

class Config
{
	private function __construct(){}
	private function __clone(){}
	
	public static function get($file = null)
	{
		if($file) {
			$filename = 'config/'.$file.'.php';
			if(is_file($filename)) {
				return require_once
				$filename;
			}
		}
		return false;
	}
}