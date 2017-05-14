<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class AuthorityManage extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取用户操作权限
	public function get(){
		$username = Request::instance()->header("username");

		$user = Db::table("sxy_people_info")->where("username", $username)->find();
		$data = Db::table("sxy_authority_info")->where("username", $username)->find();
		// 如果不存在该用户
		if(is_null($user))
			$result = ["exist" => false];
		// 如果不存在用户权限信息
		else if(is_null($data) || $data['module'] =='' || empty($data['module'])){ 
			$result = ["exist" => true, "modules" =>[], "msg" => "初始化目录树失败!"];
		} else {
			$arr = explode("-", $data["module"]);
			sort($arr);
			$result = ["exist" => true, "modules" => $arr];
		}

		echo json_encode($result);
	}

	// 创建用户操作权限
	public function update(){
		$username = Request::instance()->post("username");
		$creator_id = Request::instance()->post("creator_id");
		$module = Request::instance()->post("module");

		// 不存在该用户权限信息,则插入; 否则更新
		$tmp = Db::table("sxy_authority_info")->where("username", $username)->find();
		if(is_null($tmp)){
			$data = [
				"username" 		=> $username,
				"creator_id"	=> $creator_id,
				"module"		=> $module
			];
			$flg = Db::table("sxy_authority_info")->insert($data);
			$result = ["flg" => $flg];
		} else{
			$data = [
				"creator_id"	=> $creator_id,
				"module"		=> $module
			];
			$flg = Db::table("sxy_authority_info")->where("username", $username)->update($data);
			$result = $flg == 1 ? ["flg" => 1]: ["flg" =>1 , "msg" =>"数据库无改动!"];
		}

		echo json_encode($result);
	}
}
?>