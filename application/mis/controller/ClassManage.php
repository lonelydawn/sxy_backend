<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class ClassManage extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取所有班级类型
	public function getClassType(){
		// $arr = new array();
		$data = Db::table("sxy_class_type")->select();
		$arr = array();
		for($i=0; $i<sizeof($data); $i++)
			$arr[$i] = $data[$i]['name'];
		echo json_encode($arr);
	}

	// 获取所有班级
	public function getAllClass(){
		$data = Db::table("sxy_class_info")->select();
		echo json_encode($data);
	}

	// 查询班级
	public function getPage(){
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");
		$keyword = urldecode(Request::instance()->header("keyword"));

		$count = Db::table("sxy_class_info")
			->where("name","like","%".$keyword."%")
			->count();

		$data = Db::table("sxy_class_info")
			->where("name","like","%".$keyword."%")
			->order('id desc')
			->limit($pageNum*$pageSize, $pageSize)->select();

		$result = ["items" => $data, "count" => $count];
		echo json_encode($result);
	}

	// 创建班级
	public function create(){
		$num = Request::instance()->post("num");
		$name = Request::instance()->post("name");
		$type = Request::instance()->post("type");
		$profile = Request::instance()->post("profile"); 
		$state = Request::instance()->post("state");

		$data = [
			"num" => $num,
			"name" => $name,
			"type" => $type, 
			"profile" => $profile, 
			"state"=> $state
		];
		$flg = Db::table("sxy_class_info")->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 修改班级
	public function update(){
		$id = Request::instance()->post("id");
		$num = Request::instance()->post("num");
		$name = Request::instance()->post("name");
		$type = Request::instance()->post("type");
		$profile = Request::instance()->post("profile");
		$state = Request::instance()->post("state");

		$data = [
			"num" => $num,
			"name" => $name,
			"type" => $type,
			"profile" => $profile,
			"state" => $state
		];
		$flg = Db::table("sxy_class_info")->where("id",$id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];
		echo json_encode($result);
	}

	// 删除班级
	public function delete(){
		$id = Request::instance()->post("id");
		$flg = Db::table("sxy_class_info")->where('id',$id)->delete();
		$result = ["flg" => $flg];
		echo json_encode($result);
	}
}
?>