<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class SelfInfo extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取学生信息
	public function getStudent(){
		$id = Request::instance()->header("id");
		$result = DB::table("sxy_student_info")->where("people_id", $id)->find();
		// 获取学生所在班级名称
		if(!is_null($result['class_id'])){
			$class = DB::table("sxy_class_info")->where("id", $result['class_id'])->find();
			$result['class_name'] = $class['name'];
		}
		echo json_encode($result);
	}

	// 更新学生信息
	public function updateStudent(){
		$id = Request::instance()->post("id");
		$birth = Request::instance()->post("birth");
		$phone_number = Request::instance()->post("phone_number");
		$email = Request::instance()->post("email");
		$department = Request::instance()->post("department");

		$data = [
			"birth" 		=> $birth,
			"phone_number"	=> $phone_number,
			"email"			=> $email,
			"department"	=> $department
		];

		$flg = DB::table("sxy_student_info")->where("id", $id)->update($data);
		$result = ["flg" => $flg];
		echo json_encode($result);
	}

	// 更新学生头像
	public function updateStudentPhoto(){
		$id = Request::instance()->post("id");
		$photo_path = Request::instance()->post("photo_path");

		$data = [
			"photo_path" 		=> $photo_path
		];

		$flg = DB::table("sxy_student_info")->where("id", $id)->update($data);
		$result = ["flg" => $flg];
		echo json_encode($result);
	}

	// 获取教师信息
	public function getTeacher(){
		$id = Request::instance()->header("id");
		$result = DB::table("sxy_teacher_info")->where("people_id", $id)->find();
		echo json_encode($result);
	}

	// 更新教师信息
	public function updateTeacher(){
		$id = Request::instance()->post("id");
		$birth = Request::instance()->post("birth");
		$phone_number = Request::instance()->post("phone_number");
		$email = Request::instance()->post("email");
		$profile = Request::instance()->post("profile");
		$type = Request::instance()->post("type");

		$data = [
			"birth" 		=> $birth,
			"phone_number"	=> $phone_number,
			"email"			=> $email,
			"profile"			=> $profile,
			"type"			=> $type
		];

		$flg = DB::table("sxy_teacher_info")->where("id", $id)->update($data);
		$result = ["flg" => $flg];
		echo json_encode($result);
	}

	// 更新教师头像
	public function updateTeacherPhoto(){
		$id = Request::instance()->post("id");
		$photo_path = Request::instance()->post("photo_path");

		$data = [
			"photo_path" 		=> $photo_path
		];

		$flg = DB::table("sxy_teacher_info")->where("id", $id)->update($data);
		$result = ["flg" => $flg];
		echo json_encode($result);
	}

	// 修改密码
	public function updatePassword(){
		$id = Request::instance()->post("id");
		$password =Request::instance()->post("password");

		$data = [
			"id"		=> $id,
			"password"	=> $password
		];

		$flg = DB::table("sxy_people_info")->where("id", $id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];

		echo json_encode($result);
	}
}
?>