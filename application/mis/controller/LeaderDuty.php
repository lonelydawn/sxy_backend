<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class LeaderDuty extends Controller{
	public function _empty(){
		$msg = ["msg" => "请求错误!"];
		echo json_encode($msg);
	}

	public function getAll(){
		$data = Db::table("sxy_duty_info")->select();
		$result = array();
		for($i = 0; $i<sizeof($data); $i++){
			$result[$i]["num"] = $data[$i]["num"];
			$result[$i]["name"] = $data[$i]["name"];
			$result[$i]["content"] = $data[$i]["content"];
			$result[$i]["create_time"] = $data[$i]["create_time"];
			// 查询编辑者姓名
			$creator_id = $data[$i]["creator_id"];
			if(!is_null($creator_id))
				$editor = Db::table("sxy_people_info")->where("id",$creator_id)->find();
			$result[$i]["editor"] = is_null($editor)? "未知": $editor["name"];
		}
		echo json_encode($result);
	}
}

?>