<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class PropagateManage extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取分页内容
	public function getPage(){
		$tableIndex = Request::instance()->header("tableIndex");
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");

		$data = Db::table(getPropagateManageTableName($tableIndex))
			->order('id desc')
			->limit($pageNum*$pageSize, $pageSize)->select();

		// 添加额外字段
		for($i = 0; $i<sizeof($data); $i++)
			if($tableIndex == 2){
				// 课程宣传表 添加课程名称
				$course = Db::table("sxy_course_info")
					->where("id", $data[$i]["course_id"])->find();
				$data[$i]["course_name"] = $course["name"];
			} else if($tableIndex ==3 ){
				// 优秀学子宣传表 添加学生姓名
				$student = Db::table("sxy_people_info")
					->where("id", $data[$i]["student_id"])->find();
				$data[$i]["student_name"] = $student["name"];
			}

		echo json_encode($data);
	}

	// 获取所有条目数
	public function getTotalItem(){
		$tableIndex = Request::instance()->header("tableIndex");
		$data = Db::table(getPropagateManageTableName($tableIndex))->count(1);
		echo json_encode(["count" => $data]);
	}

	// 获取当前查询条目
	public function getCurrent(){
		$tableIndex = Request::instance()->header("tableIndex");
		$id = Request::instance()->header("id");
		
		$table = getPropagateManageTableName($tableIndex);
		$result = Db::table($table)->where("id", $id)->find();
		echo json_encode($result);
	}

	// 创建企业宣传
	public function createCompany(){
		$tableIndex = Request::instance()->post("table_index");

		$title = Request::instance()->post("title");
		$content = Request::instance()->post("content");
		$company_name = Request::instance()->post("company_name");
		$company_type = Request::instance()->post("company_type");
		$company_address = Request::instance()->post("company_address");
		$phone_number = Request::instance()->post("phone_number");
		$picture_path = Request::instance()->post("picture_path");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"title" => $title,
			"content" => $content,
			"company_name" => $company_name, 
			"company_type" => $company_type, 
			"company_address" => $company_address,
			"phone_number" => $phone_number,
			"picture_path" => $picture_path, 
			"creator_id" => $creator_id
		];
		$flg = Db::table(getPropagateManageTableName($tableIndex))->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 创建活动宣传
	public function createActivity(){
		$tableIndex = Request::instance()->post("table_index");
		$title = Request::instance()->post("title");
		$content = Request::instance()->post("content");
		$type = Request::instance()->post("type");
		$corporation = Request::instance()->post("corporation");
		$phone_number = Request::instance()->post("phone_number");
		$picture_path = Request::instance()->post("picture_path");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"title" => $title,
			"content" => $content,
			"type" => $type, 
			"corporation" => $corporation, 
			"phone_number" => $phone_number,
			"picture_path" => $picture_path, 
			"creator_id" => $creator_id
		];
		$flg = Db::table(getPropagateManageTableName($tableIndex))->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 创建课程宣传
	public function createCourse(){
		$tableIndex = Request::instance()->post("table_index");
		$course_id = Request::instance()->post("course_id");
		$title = Request::instance()->post("title");
		$content = Request::instance()->post("content");
		$picture_path = Request::instance()->post("picture_path");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"course_id" => $course_id, 
			"title" => $title,
			"content" => $content,
			"picture_path" => $picture_path, 
			"creator_id" => $creator_id
		];
		$flg = Db::table(getPropagateManageTableName($tableIndex))->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 创建优秀学子
	public function createStudent(){
		$tableIndex = Request::instance()->post("table_index");
		$student_id = Request::instance()->post("student_id");
		$profile = Request::instance()->post("profile");
		$honor = Request::instance()->post("honor");
		$declaration = Request::instance()->post("declaration");
		$photo_path = Request::instance()->post("photo_path");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"student_id" => $student_id, 
			"profile" => $profile,
			"honor" => $honor,
			"declaration" => $declaration,
			"photo_path" => $photo_path, 
			"creator_id" => $creator_id
		];
		$flg = Db::table(getPropagateManageTableName($tableIndex))->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 修改企业宣传
	public function updateCompany(){
		$tableIndex = Request::instance()->post("table_index");
		$id = Request::instance()->post("id");
		$title = Request::instance()->post("title");
		$content = Request::instance()->post("content");
		$company_name = Request::instance()->post("company_name");
		$company_type = Request::instance()->post("company_type");
		$company_address = Request::instance()->post("company_address");
		$phone_number = Request::instance()->post("phone_number");
		$picture_path = Request::instance()->post("picture_path");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"title" => $title,
			"content" => $content,
			"company_name" => $company_name, 
			"company_type" => $company_type, 
			"company_address" => $company_address,
			"phone_number" => $phone_number,
			"picture_path" => $picture_path, 
			"creator_id" => $creator_id
		];
		$flg = Db::table(getPropagateManageTableName($tableIndex))
			->where("id", $id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];

		echo json_encode($result);
	}

	// 修改活动宣传
	public function updateActivity(){
		$tableIndex = Request::instance()->post("table_index");
		$id = Request::instance()->post("id");
		$title = Request::instance()->post("title");
		$content = Request::instance()->post("content");
		$type = Request::instance()->post("type");
		$corporation = Request::instance()->post("corporation");
		$phone_number = Request::instance()->post("phone_number");
		$picture_path = Request::instance()->post("picture_path");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"title" => $title,
			"content" => $content,
			"type" => $type, 
			"corporation" => $corporation, 
			"phone_number" => $phone_number,
			"picture_path" => $picture_path, 
			"creator_id" => $creator_id
		];
		$flg = Db::table(getPropagateManageTableName($tableIndex))
			->where("id", $id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];

		echo json_encode($result);
	}

	// 修改课程宣传
	public function updateCourse(){
		$tableIndex = Request::instance()->post("table_index");
		$id = Request::instance()->post("id");
		$course_id = Request::instance()->post("course_id");
		$title = Request::instance()->post("title");
		$content = Request::instance()->post("content");
		$picture_path = Request::instance()->post("picture_path");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"course_id" => $course_id, 
			"title" => $title,
			"content" => $content,
			"picture_path" => $picture_path, 
			"creator_id" => $creator_id
		];
		$flg = Db::table(getPropagateManageTableName($tableIndex))
			->where("id", $id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];

		echo json_encode($result);
	}

	// 修改优秀学子
	public function updateStudent(){
		$tableIndex = Request::instance()->post("table_index");
		$id = Request::instance()->post("id");
		$student_id = Request::instance()->post("student_id");
		$profile = Request::instance()->post("profile");
		$honor = Request::instance()->post("honor");
		$declaration = Request::instance()->post("declaration");
		$photo_path = Request::instance()->post("photo_path");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"student_id" => $student_id, 
			"profile" => $profile,
			"honor" => $honor,
			"declaration" => $declaration,
			"photo_path" => $photo_path, 
			"creator_id" => $creator_id
		];
		$flg = Db::table(getPropagateManageTableName($tableIndex))
			->where("id", $id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];

		echo json_encode($result);
	}

	// 删除企业宣传
	public function delete(){
		$tableIndex = Request::instance()->post("table_index");
		$id = Request::instance()->post("id");

		$flg = Db::table(getPropagateManageTableName($tableIndex))
			->where("id", $id)->delete();
		$result = ["flg" => $flg];

		echo json_encode($result);
	}
}
?>