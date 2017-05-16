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
		
		// $student_id = 2;

		// $result = DB::query("select d.name as course_name,e.name as teacher_name,d.type,d.score ".
		// 	"from sxy_course_distribute a left join sxy_class_info b on a.class_id=b.id ".
		// 	"left join sxy_student_info c on c.class_id=b.id left join sxy_course_info d ".
		// 	"on a.course_id=d.id left join sxy_teacher_info e on d.teacher_id=e.people_id ".
		// 	"where c.people_id=:student_id group by(a.course_id) limit :size",
		// 	["student_id" => $student_id, "size" => $size]);

		$result = array();
		$index=0;
		$student = DB::table("sxy_student_info")->where("people_id",$student_id)->find();
		if(!is_null($student)&&!is_null($student['class_id'])){
			$courses = DB::table("sxy_course_distribute")
			->distinct(true)
			->field("course_id")
			->where("class_id", $student['class_id'])
			->select();
			for($i=0; $i<sizeof($courses) && $i<$size; $i++){
				$course = DB::table("sxy_course_info")
				->where("id",$courses[$i]['course_id'])
				->find();
				if(!is_null($course)&&!is_null($course['teacher_id'])){
					$teacher = DB::table("sxy_teacher_info")
					->where("people_id", $course['teacher_id'])
					->find();
					if(!is_null($teacher)&&!is_null($teacher['name']))
						$course['teacher_name']=$teacher['name'];
					$result[$index++] = $course;
				}
			}
		}
		
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