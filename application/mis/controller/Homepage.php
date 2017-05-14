<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class Homepage extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取学生课程信息
	public function getCourseInfo(){
		$student_id = Request::instance()->header("studentId");
		$size = 3;

		$result = DB::query("select d.name as course_name,e.name as teacher_name,d.type,d.score ".
			"from sxy_course_distribute a left join sxy_class_info b on a.class_id=b.id ".
			"left join sxy_student_info c on c.class_id=b.id left join sxy_course_info d ".
			"on a.course_id=d.id left join sxy_teacher_info e on d.teacher_id=e.people_id ".
			"where c.people_id=:student_id group by(a.course_id) limit :size",
			["student_id" => $student_id, "size" => $size]);

		echo json_encode($result);
	}

	// 获取企业宣传
	public function getPropagate(){
		$tableIndex = Request::instance()->header("tableIndex");
		$size = 3;

		$result = DB::table(getPropagateManageTableName($tableIndex))
		->order("id desc")
		->limit($size)
		->select();

		echo json_encode($result);
	}
}
?>