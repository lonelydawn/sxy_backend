<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class SystemManage extends Controller{
	public function _empty(){
		$msg = ["msg" => "请求错误!"];
		echo json_encode($msg);
	}

	// 获取所有信息
	public function getAll(){
		$tableIndex = Request::instance()->header("tableIndex");
		$table = getSystemManageTableName($tableIndex);
		$arr = Db::table($table)->select();
		echo json_encode($arr);
	}

	// 查询制度 || 职责
	public function search(){
		echo json_encode(["flg"=>0, "msg" => "方法未完成"]);
	}

	// 创建制度 || 职责
	public function create(){
		// 获取所用表名称
		$tableIndex = Request::instance()->post("tableIndex");
		$table = getSystemManageTableName($tableIndex);

		// 获取录入数据
		$number = Request::instance()->post("number");
		$name = Request::instance()->post("name");
		$creator_id = Request::instance()->post("creator_id");
		$content = Request::instance()->post("content");

		$data = [
			"num" => $number,
			"name" => $name,
			"creator_id" => $creator_id, 
			"content" => $content
		];
		$flg = Db::table($table)->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 删除制度 || 职责
	public function delete(){
		$tableIndex = Request::instance()->post("tableIndex");
		// $tableIndex =0;
		$table = getSystemManageTableName($tableIndex);
		$number = Request::instance()->post("number");
		// $number = "1002";

		$flg = Db::table($table)->where('num',$number)->delete();
		if($flg == 0)
			$result = ["flg" => $flg, "msg" => "不存在该条记录!"];
		else $result = ["flg" => $flg];
		echo json_encode($result);
	}
}

?>