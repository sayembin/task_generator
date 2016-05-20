<?php

namespace Config;

/**
 * this is a configuration class to configure your app settings in here
 * Class config
 *
 * @package TodoApp\config
 * @author Md.Sayem bin hasan <sayemdoc@gmail.com>
 */
class config
{

	/**
	 * this method returns the todoapp settings array
	 * you can configure settings array here
	 *
	 * @return Array
	 */
	public static function  getConfig()
	{
		return array(
			'host'=>'127.0.0.1',
			'user'=>'root',
			'password'=>'',
			'dbname'=>'xtwo_todo_app',
			'base_url'=> 'http://'.$_SERVER['HTTP_HOST'].DIRECTORY_SEPARATOR.'todo_app_sayem',
		);
	}
} 