<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class StudentManage extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取分页内容
	public function getPage(){
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");
		$keyword = urldecode(Request::instance()->header("keyword"));

		$count = Db::table("sxy_student_info")
			->where("name","like","%".$keyword."%")
			->count();

		$data = Db::table("sxy_student_info")
			->where("name","like","%".$keyword."%")
			->order('id desc')
			->limit($pageNum*$pageSize, $pageSize)->select();

		for($i=0;$i<sizeof($data);$i++){
			if(!is_null($data[$i]['class_id'])){
				$class = Db::table("sxy_class_info")->where("id",$data[$i]['class_id'])->find();
				$data[$i]['class_name'] = $class['name'];
			}
		}

		$result = ["items" => $data, "count" => $count];
		echo json_encode($result);
	}

	// 更新学生信息
	public function update(){
		$id = Request::instance()->post("id");
		$name = Request::instance()->post("name");
		$sex = Request::instance()->post("sex");
		$class_id = Request::instance()->post("class_id");
		$profile_number = Request::instance()->post("profile_number");
		$state = Request::instance()->post("state");

		$data = [
			"id"			=> $id,
			"name" 			=> $name,
			"sex" 			=> $sex,
			"class_id" 		=> $class_id,
			"profile_number"=> $profile_number,
			"state" 		=> $state
		];


		$flg = Db::table("sxy_student_info")->where("id",$id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];
		echo json_encode($result);
	}
}
?>