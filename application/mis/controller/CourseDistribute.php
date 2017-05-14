<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class CourseDistribute extends Controller{
	public function _empty(){
		$msg = ["msg" => "请求错误!"];
		echo json_encode($msg);
	}

	// 分配课程
	public function distribute(){
		$creator_id = Request::instance()->post("creator_id");
		$class_id = Request::instance()->post("class_id");
		$course_id = Request::instance()->post("course_id");
		$allocation = Request::instance()->post("allocation");
		$address = Request::instance()->post("address");
		$begin_week =Request::instance()->post("begin_week");
		$end_week =Request::instance()->post("end_week");

		// 检测班级当前节数是否有课程
		$exist = DB::table("sxy_course_distribute")
		->where(["class_id" => $class_id, "allocation" => $allocation])->find();

		//  如果班级当前节数未有课程, 则插入
		if(is_null($exist)){
			$data = [
				"creator_id"	=> $creator_id,
				"class_id" 		=> $class_id,
				"course_id" 	=> $course_id,
				"allocation" 	=> $allocation, 
				"address" 		=> $address,
				"begin_week"	=> $begin_week,
				"end_week"		=> $end_week
			];
			$flg = Db::table("sxy_course_distribute")->insert($data);
		} else {	// 否则更新
			$data = [
				"creator_id"	=> $creator_id,
				"course_id" 	=> $course_id,
				"address" 		=> $address,
				"begin_week"	=> $begin_week,
				"end_week"		=> $end_week
			];
			$flg = Db::table("sxy_course_distribute")
			->where(["class_id" => $class_id, "allocation" => $allocation])->update($data);
		}
		$result = ["flg" => $flg];
		echo json_encode($result);
	}

	// 获取已分配课程
	public function getDistribution(){
		$class_id = Request::instance()->header("classId");
		$result = DB::table("sxy_course_distribute")->where("class_id", $class_id)->select();
		echo json_encode($result);
	}

	public function deleteDistribution(){
		$class_id = Request::instance()->header("classId");
		$allocation = Request::instance()->header("allocation");

		$flg =  DB::table("sxy_course_distribute")
		->where(["class_id" => $class_id, "allocation" => $allocation])->delete();

		$result = $flg >0 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无此条目!"];
		echo json_encode($result);
	}
}

?>