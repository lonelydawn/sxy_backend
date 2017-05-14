<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;

class Login extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	public function login(){
		$username = Request::instance()->post('username');
		$password = Request::instance()->post('password');
		// $username = "a";
		// $password ="a";
		// $exist = model('clients')->where(['username'=>$username,'password'=>$password])->find();
		
		$exist = Db::table("sxy_people_info")->where(['username'=>$username,'password'=>$password])->find();
		if(is_null($exist))
			$results = ['in' =>false];
		else {
			$token = $this->request->token($username.$password,'sha1');
			Session::set('token',$token);
			$results = ['token'=>$token, 'in'=>true, 'role'=>$exist];
		}
        
		// $results = ['in'=>!is_null($exist)];

		echo json_encode($results);
	}
}
?>