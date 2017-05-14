<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;

class UserManage extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取所有教师
	public function getAllTeachers(){
		$data = Db::table("sxy_people_info")->where(["type" => "教师", "state" => 1])->select();
		echo json_encode($data);
	}

	// 获取所有学生
	public function getAllStudents(){
		$data = Db::table("sxy_people_info")->where(["type" => "学生", "state" => 1])->select();
		echo json_encode($data);
	}

	// 查询用户
	public function search(){
		$username = Request::instance()->header("username");
		$user = Db::table('sxy_people_info')->where('username', $username)->find();
		if(is_null($user))
			$result = ["exists"=>false ,"msg"=> "用户不存在"];
		else $result = ["exists"=>true , "user"=>$user];
		echo json_encode($result);
	}

	// 创建用户
	public function create(){
		$name = Request::instance()->post("name");
		$username = Request::instance()->post("username");
		$password = Request::instance()->post("password"); 
		$type = Request::instance()->post("type");
		$data = [
			"name" => $name, 
			"username" => $username, 
			"password" => $password, 
			"type" => $type, 
			"state"=>true
		];
		$flg = Db::table("sxy_people_info")->insert($data);
		// 将数据插入教师 | 学生表
		if($flg ==1 ){
			$user = Db::table("sxy_people_info")->where("username","$username")->find();
			$data = [
				"name"		=> $name,
				"people_id"	=> $user['id']
			];
			if($type == "教师")
				Db::table("sxy_teacher_info")->insert($data);
			else if($type == "学生")
				Db::table("sxy_student_info")->insert($data);
		}

		$result = ["flg" => $flg];
		echo json_encode($result);
	}

	// 修改用户
	public function update(){
		$username = Request::instance()->post("username");
		$name = Request::instance()->post("name");
		$password = Request::instance()->post("password");
		$type = Request::instance()->post("type");
		$state = Request::instance()->post("state");
		$data = [
			"username" => $username, 
			"name" => $name, 
			"password" => $password,
			"type" => $type,
			"state" => $state 
		];
		$flg = Db::table("sxy_people_info")->where("username",$username)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];
		echo json_encode($result);
	}

	// 删除用户
	public function delete(){
		$username = Request::instance()->post("username");
		$flg = Db::table("sxy_people_info")->where('username',$username)->delete();
		$result = ["flg" => $flg];
		echo json_encode($result);
	}
}

?>