<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class AbsenceManage extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 查询缺勤记录
	public function getPage(){
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");
		$keyword = urldecode(Request::instance()->header("keyword"));

		$tmp = Db::query('select a.*,b.name as student_name,c.name as class_name from '.
			'sxy_absence_record a left JOIN sxy_student_info b on a.student_id= b.people_id '.
			'left join sxy_class_info c on b.class_id=c.id where a.course_name like :keyword1 '.
			'or b.name like :keyword2 or c.name like :keyword3 order by a.id desc',
			["keyword1"=>"%".$keyword."%","keyword2"=>"%".$keyword."%",
			"keyword3"=>"%".$keyword."%"]);

		$data = array();
		for($i=0;$i<$pageSize && $pageSize*$pageNum+$i<sizeof($tmp);$i++)
			$data[$i] = $tmp[$pageSize*$pageNum+$i];

		$result = ["items" => $data, "count" => sizeof($tmp)];
		echo json_encode($result);
	}

	// 创建缺勤记录
	public function create(){
		$course_id = Request::instance()->post("course_id");
		$course_name = Request::instance()->post("course_name");
		$student_num = Request::instance()->post("student_num");
		$absence_date = Request::instance()->post("absence_date");
		$is_count = Request::instance()->post("is_count"); 
		$absence_reason = Request::instance()->post("absence_reason");

		// 判断学生是否存在
		$exist = DB::table("sxy_people_info")
		->where(["username" => $student_num, "type"  => "学生"])
		->find();

		if(is_null($exist))
			$result = ["flg" => 0, "msg" => "学生不存在!"];
		else {
			$data = [
				"course_id" 		=> $course_id,
				"course_name" 		=> $course_name,
				"student_id" 		=> $exist['id'],
				"student_num" 		=> $student_num,
				"absence_date" 		=> $absence_date, 
				"is_count" 			=> $is_count, 
				"absence_reason"	=> $absence_reason
			];
			$flg = Db::table("sxy_absence_record")->insert($data);
			$result = ["flg" => $flg];
		}

		echo json_encode($result);
	}

	// 修改缺勤记录
	public function update(){
		$id = Request::instance()->post("id");
		$course_id = Request::instance()->post("course_id");
		$course_name = Request::instance()->post("course_name");
		$student_id = Request::instance()->post("student_id");
		$student_num = Request::instance()->post("student_num");
		$absence_date = Request::instance()->post("absence_date");
		$is_count = Request::instance()->post("is_count"); 
		$absence_reason = Request::instance()->post("absence_reason");

		// 判断学生是否存在
		$exist = DB::table("sxy_people_info")
		->where(["username" => $student_num, "type"  => "学生"])
		->find();

		if(is_null($exist))
			$result = ["flg" => 0, "msg" => "学生不存在!"];
		else {
			$data = [
				"course_id" 		=> $course_id,
				"course_name" 		=> $course_name,
				"student_id" 		=> $exist['id'],
				"student_num" 		=> $student_num,
				"absence_date" 		=> $absence_date, 
				"is_count" 			=> $is_count, 
				"absence_reason"	=> $absence_reason
			];
			$flg = Db::table("sxy_absence_record")->where("id",$id)->update($data);
			$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];
		}
		echo json_encode($result);
	}

	// 删除缺勤记录
	public function delete(){
		$id = Request::instance()->post("id");
		$flg = Db::table("sxy_absence_record")->where('id',$id)->delete();
		$result = ["flg" => $flg];
		echo json_encode($result);
	}

	// 根据收支类型获取各大类收支金额
	public function getAbsenceByCourse(){
		$class_id = urldecode(Request::instance()->header("classId"));
		$begin_date = urldecode(Request::instance()->header("beginDate"));
		$end_date = urldecode(Request::instance()->header("endDate"));

		$is_count = true;

		$data = DB::query("select course_name,count(*) as count from sxy_absence_record a ".
			"left join sxy_student_info b on a.student_id=b.people_id left join sxy_class_info ".
			"c on b.class_id=c.id left join sxy_course_info d on a.course_id=d.id ".
			"where a.create_time between :begin_date and :end_date and c.id=:class_id ".
			"and is_count=:is_count group by course_name;",
			["begin_date" => $begin_date, "end_date" => $end_date,"class_id" => $class_id, 
			"is_count" => $is_count]);

		echo json_encode($data);
	}
}
?>