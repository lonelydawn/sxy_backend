<?php
	return [
		// 应用命名空间
		'app_namespace'          => 'app',
	    // 应用调试模式
	    'app_debug'              => true,
	    // 应用Trace
	    'app_trace'              => true,
	    // 数据库连接参数
		'database'				=> [
		    // 数据库类型
		    'type'        => 'mysql',
		    // 服务器地址
		    'hostname'    => '127.0.0.1',
		    // 数据库名
		    'database'    => 'sxy_mis',
		    // 数据库用户名
		    'username'    => 'root',
		    // 数据库密码
		    'password'    => '',
		    // 数据库连接端口
		    'hostport'    => '3306',
		    // 数据库编码默认采用utf8
		    'charset'     => 'utf8',
		    // 数据库表前缀
		    'prefix'      => '',
		    // 数据库调试模式
		    'debug'       => true,
		    // 是否严格检查字段是否存在
		    'fields_strict'  => true,
		    // 开启自动写入时间戳并设置类型 
		    // 'auto_timestamp' => 'datetime', 
		],
		// session配置参数
		'session'                => [
		    // 'prefix'        => 'module',
		    'type'          => '',
		    'expire'		=> 5,
		    'auto_start'    => true,
		],
	]
?>