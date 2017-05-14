<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class CourseManage extends Controller{
	public function _empty(){
		$msg = ["msg" => "请求错误!"];
		echo json_encode($msg);
	}

	public function getCourseType(){
		$data = Db::table("sxy_course_type")->select();
		$arr = array();
		for($i=0; $i<sizeof($data); $i++)
			$arr[$i] = $data[$i]['name'];
		echo json_encode($arr);
	}

	public function getAllCourses(){
		$data = Db::table("sxy_course_info")->select();
		echo json_encode($data);
	}

	// 查询课程
	public function getPage(){
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");
		$keyword = urldecode(Request::instance()->header("keyword"));

		$count = Db::table("sxy_course_info")
			->where("name","like","%".$keyword."%")
			->count();

		$data = Db::table("sxy_course_info")
			->where("name","like","%".$keyword."%")
			->order('id desc')
			->limit($pageNum*$pageSize, $pageSize)->select();

		for($i=0;$i<sizeof($data);$i++){
			if(!is_null($data[$i]['teacher_id'])){
				$teacher = Db::table("sxy_people_info")->where("id",$data[$i]['teacher_id'])->find();
				$data[$i]['teacher_name'] = $teacher['name'];
			}
		}

		$result = ["items" => $data, "count" => $count];
		echo json_encode($result);
	}

	// 创建课程
	public function create(){
		$num = Request::instance()->post("num");
		$teacher_id = Request::instance()->post("teacher_id");
		$name = Request::instance()->post("name");
		$score = Request::instance()->post("score");
		$type = Request::instance()->post("type");

		$data = [
			"num"			=> $num,
			"teacher_id" 	=> $teacher_id,
			"name" 			=> $name,
			"score" 		=> $score, 
			"type" 			=> $type
		];
		$flg = Db::table("sxy_course_info")->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 修改班级
	public function update(){
		$id = Request::instance()->post("id");
		$num = Request::instance()->post("num");
		$teacher_id = Request::instance()->post("teacher_id");
		$name = Request::instance()->post("name");
		$score = Request::instance()->post("score");
		$type = Request::instance()->post("type");

		$data = [
			"num"			=> $num,
			"teacher_id" 	=> $teacher_id,
			"name" 			=> $name,
			"score" 		=> $score, 
			"type" 			=> $type
		];
		$flg = Db::table("sxy_course_info")->where("id",$id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];
		echo json_encode($result);
	}

	// 删除班级
	public function delete(){
		$id = Request::instance()->post("id");
		$flg = Db::table("sxy_course_info")->where('id', $id)->delete();
		$result = ["flg" => $flg];
		echo json_encode($result);
	}
}


?>