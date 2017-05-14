<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class ConfigManage extends Controller{

	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取当前配置想存在数据
	public function getCurrent(){
		$tableIndex = Request::instance()->header("tableIndex");
		
		$result = Db::table(getConfigTableName($tableIndex))->select();
		echo json_encode($result);
	}

	// 创建配置项数据
	public function create(){
		$tableIndex = Request::instance()->post("tableIndex");
		$name = Request::instance()->post("configItemData");

		$flg = Db::table(getConfigTableName($tableIndex))->insert(["name" => $name]);
		$result = ["flg" => $flg];
		echo json_encode($result);
	}
}
?>