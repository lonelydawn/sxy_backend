<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
// use \Model\Test;
// use Model\QinDynastryCharacter;

//1.请求						√
//2.数据库连接 				
//3.输出数据					

class Test extends Controller{
	// 前置操作
	// protected $beforeActionList = [
	// 	'first',
	// 	'second'		=>['only'	=>','],
	// 	'third'			=>['except'	=>',']
 //    ];

	// 初始化方法,调用其他操作之前先调用初始化方法
	// protected function _initialize(){
	// 	echo 'init<br/>';
	// }

	// 空方法
	public function _empty(){
		echo 'this is a empty action<br/>';
	}

	public function getCharacter(){
		// $t=model('Test');
		// $obj=new $t();
		$arr=['data'=>model('Test')->select()];
		// dump($obj->select());
		echo json_encode($arr);

		// $exists = model('Test')->where('id',100)->find();
		// $arr = ['login-in' => !is_null(model('Test')->where('id',100)->find())];
		// echo json_encode($arr);
		// dump(is_null($exists));
		// echo is_null($exists);
	}

	// public function request(){
	// 	echo Request::instance()->param('hello').'<br/>';
	// 	echo Request::instance()->get('hello').'<br/>';
	// 	echo Request::instance()->post('hello').'<br/>';
	// 	echo Request::instance()->request('hello').'<br/>';
	// 	echo Request::instance()->server('host_name').'<br/>';

	// 	Request::instance()->session(['hello'=>'china']);
	// 	echo Request::instance()->session('hello').'<br/>';
	// }

	// public function setSession(){
	// 	session('dot','idot');
	// }

	// public function getSession(){
	// 	echo session('dot');
	// }

	// 测试模型
	// public function testModel(){
	// 	// $t=model('QinDynastryCharacter');
	// 	// $t=model('Test');
	// 	// dump($t);
	// 	// $obj=$t::get(9);
	// 	// echo $obj->toJson();
	// 	// $obj=new $t();
	// 	// $obj->id=9;
	// 	// $obj->name='范增3';
	// 	// $obj->birth='151-11-12';
	// 	// $obj->profile='秦末著名谋士,项羽亚父,若从其计,西楚霸业可成.';
	// 	// $obj->save();
	// 	// $obj->delete();
	// 	// echo $obj->name;
	// 	// echo $t->where('id','lt',5)->count('1');
	// 	// dump($t->where('id','eq',5)->find()->toArray());

	// 	// 双引号内的变量会执行, 单引号里的变量不会执行
	// 	$v=validate('Test');
	// 	$data=[
	// 		'email' =>'hellowo@rld.com',
	// 		'name'	=>'ssssss',
	// 		'age'	=>'12',
	// 	];

	// 	$result=$v->check($data);
	// 	echo $result;
	// 	// getError只返回最先检测到的错误
	// 	dump($v->getError());
	// }

	// 测试数据库连接
	// public function testConnect(){
	// 	$arr=Db::query('select * from test where id=?',[3]);
	// 	dump($arr);
	// }

	// 测试数据库查询
	// public function testSelect(){
	// 	// $arr=Db::table('test')->where('id',1)->select();
	// 	// dump($arr);

	// 	$arr=Db::table('test')->select();
	// 	dump($arr);
	// }

	// 测试数据库增加
	// public function testAdd(){
	// 	$data=['id'=>5,'name'=>'吕雉','birth'=>'199-2-3','profile'=>'刘邦之妻,沛县吕老之女,设计杀韩信.'];
	// 	$flg=Db::table('test')->insert($data);
	// 	dump($flg);

	// 	// 测试助手函数
	// 	$data=['id'=>6,'name'=>'韩信','birth'=>'194-7-23','profile'=>'经典数不胜数,后因功高震主,计杀于吕后之手.'];
	// 	$flg=db('test')->insert($data);
	// 	dump($flg);
	// }

	// 测试数据库更新
	// public function testUpdate(){
	// 	db('test')->where('id',1)->update(['name'=>'虞美人']);
	// 	$this->testSelect();
	// }

	// 测试数据库删除
	// public function testDelete(){
	// 	// db('test')->where('id',5)->delete();
	// 	db('test')->where('id','lt',10)->delete();
	// 	$this->testSelect();
	// }

	// 测试数据转移
	// public function testMigrate(){
	// 	$data=db('qin_dynastry_character')->select();
	// 	dump($data);

	// 	db('test')->insertAll($data);
	// }

	// 测试页面跳转和重定向
	// public function test(){
	// 	$this->success('设置成功');
	// 	$this->error('设置失败');
	// }

	// 测试路由
	// public function test(){
	// 	echo "<h1>This is index action of Test Controller</h1><br/>".config('database.type');
	// }

	// 测试配置文件
	public function test(){
		// echo config('database.type');
		echo Request::instance()->get("hello");
	}
}

?>