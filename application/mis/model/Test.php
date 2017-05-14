<?php
namespace app\mis\model;
use think\Model;


class Test extends Model{
	// 自动添加时间戳 ,必须存在 update_time & create_time字段
	protected $autoWriteTimestamp = 'datetime';
	// 设置字段只读不可写
	protected $readonly=['name'];
	// 类型自动转换
    protected $type	= [
    	'id'			=>'integer',
    	'name'			=>'string',
    	'birth'			=>'date',
    	'profile'		=>'string',
    	'update_time'	=>'datetime',
    	'create_time'	=>'datetime'
    ];
    
	// 只在类第一次创建对象时作用
	protected static function init(){

	}

	// 每次实例化对象都作用
	protected function initialize(){
		parent::initialize();
	}

	public function test(){
		echo 'hello world';
	}
}

?>