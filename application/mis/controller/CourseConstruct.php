<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class CourseConstruct extends Controller{
	public function _empty(){
		$msg = ["msg" => "请求错误!"];
		echo json_encode($msg);
	}

	// 获取单页学生课程
	public function getStudentCoursePage(){
		$id = Request::instance()->header("id");
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");
		$keyword = urldecode(Request::instance()->header("keyword"));

		$class = DB::table("sxy_student_info")->where("people_id",$id)->field("class_id")->find();
		$result = array();

		// 如果班级不为空,查询班级所有不重复课程编号
		if(!is_null($class)){
			$data = Db::table("sxy_course_distribute")
			->where("class_id", $class['class_id'])
			->distinct(true)->field('course_id')
			->select();

			// 将数组下标起始设为0, 防止其成为json数组
			$index =0;
			// 根据课程编号, 获取课程完整信息
			for($i=$pageNum*$pageSize; $i<sizeof($data)&&$i<($pageNum+1)*$pageSize;$i++){
				$course = DB::table("sxy_course_info")
				->where(["id"=>$data[$i]['course_id'], "name"=>["like","%".$keyword."%"]])
				->find();
				if(!is_null($course)){
					// 查询授课教师名称
					$teacher = DB::table("sxy_teacher_info")
					->where("people_id", $course['teacher_id'])
					->find();
					$course['teacher_name'] = $teacher['name'];
					$result["items"][$index++] = $course;
				}
			}
			$result['count'] = sizeof($data);
		}
		echo json_encode($result);
	}

	// 获取单页教师课程
	public function getTeacherCoursePage(){
		$id = Request::instance()->header("id");
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");
		$keyword = urldecode(Request::instance()->header("keyword"));

		$count = DB::table("sxy_course_info")
		->where(["teacher_id" => $id, "name" => ["like","%".$keyword."%"]])
		->count();

		$courses = DB::table("sxy_course_info")
		->where(["teacher_id" => $id, "name" => ["like","%".$keyword."%"]])
   		->order('id desc')
   		->limit($pageSize*$pageNum, $pageSize)
   		->select();

   		$result = ["items" => $courses, "count" => $count];
   		echo json_encode($result);
	}

	// 获取教师课程
	public function getTeacherCourseTable(){
		$id = Request::instance()->header("id");

		$index = 0;
		$result = array();
		// 根据教师id查询教师所教的所有课程
		$courses = DB::table("sxy_course_info")->where("teacher_id", $id)->select();
		for($i=0;$i<sizeof($courses);$i++){
			// 根据课程id获取课程分配详情
			$allocations = DB::table("sxy_course_distribute")
			->where("course_id",$courses[$i]['id'])->select();
			// 将所有课程的分配详情加入结果数组中
			for($t=0; $t<sizeof($allocations); $t++)
				$result[$index++] = $allocations[$t];
		}
		echo json_encode($result);
	}

	// 获取课程资源
	public function getResource(){
		$course_id = Request::instance()->header("courseId");
		$result = DB::table("sxy_courseware_upload")->where("course_id", $course_id)->select();
		echo json_encode($result);
	}

	// 上传课程资源
	public function uploadResource(){
		$course_id = Request::instance()->post("course_id");
		$title = Request::instance()->post("title");
		$ware_path = Request::instance()->post("ware_path");

		$data = [
			"course_id" 	=> $course_id, 
			"title" 		=> $title,
			"ware_path" 	=> $ware_path
		];

		$flg = DB::table("sxy_courseware_upload")->insert($data);

		$result = ["flg" => $flg];
		echo json_encode($result);
	}

	// 获取缺勤记录单页
	public function getAbsenceRecordPage(){
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");
		$keyword = urldecode(Request::instance()->header("keyword"));
		$student_id = Request::instance()->header("studentId");

		$tmp = Db::table("sxy_absence_record")
		->where(["course_name" => ["like","%".$keyword."%"], "student_id" => $student_id])
		->select();

		$data = array();
		for($i=0;$i<$pageSize && $pageSize*$pageNum+$i<sizeof($tmp);$i++)
			$data[$i] = $tmp[$pageSize*$pageNum+$i];

		$result = ["items" => $data, "count" => sizeof($tmp)];
		echo json_encode($result);
	}
}

?>