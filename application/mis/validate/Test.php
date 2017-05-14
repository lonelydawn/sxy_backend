<?php
namespace app\mis\validate;
use think\validate;

class Test extends Validate{
	protected $rule=[
		'email'		=>'email',
		'name|名称'		=>'require|max:5',
		'age'		=>'integer|between:1,120',
		// 'age'	=>['number','between'=>'1,120'],

	];

	// protected $message=[
	// 	'email'				=>'邮箱格式错误',
	// 	'name.require'		=>'请输入名称',
	// 	'age.integer'		=>'年龄必须为整数',
	// 	'name.max'			=>'名称长度不得超过5个字符',
	// 	'age.between'		=>'年龄范围必须在1~120之间'
	// ];
}

?>