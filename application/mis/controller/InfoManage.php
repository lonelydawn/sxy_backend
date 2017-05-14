<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class InfoManage extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取公告类型条目
	public function getAnnounceTypes(){
		$data = Db::table("sxy_announce_type")->select();
		$arr = array();
		for($i=0; $i<sizeof($data); $i++)
			$arr[$i] = $data[$i]['name'];
		echo json_encode($arr);
	}

	// 获取单页内容
	public function getPage(){
		$tableIndex = Request::instance()->header("tableIndex");
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");
		$type = urldecode(Request::instance()->header("type"));


		if($tableIndex == 0){
			$data = Db::table(getInfoManageTableName($tableIndex))
			->where("type","like",$type)
			->order('id desc')
			->limit($pageNum*$pageSize, $pageSize)->select();
			// 统计所有条目数
			$count = Db::table(getInfoManageTableName($tableIndex))
			->where("type","like",$type)
			->count();
		}else  {
			$data = Db::table(getInfoManageTableName($tableIndex))
			->order('id desc')
			->limit($pageNum*$pageSize, $pageSize)->select();
			// 统计所有条目数
			$count = Db::table(getInfoManageTableName($tableIndex))
			->count();
		}

		for($i=0; $i<sizeof($data); $i++){
			$tmp = Db::table("sxy_people_info")
				->where("id", $data[$i]["creator_id"])->find();
			if(!is_null($tmp)) $data[$i]["creator_name"] = $tmp["name"];
		}
		$result = ["items" => $data, "count" => $count];
		echo json_encode($result);
	}

	// 创建系统公告
	public function createAnnounce(){
		$tableIndex = Request::instance()->post("tableIndex");
		$content = Request::instance()->post("content");
		$type = Request::instance()->post("type");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"content"	=>	$content,
			"type"		=>	$type,
			"creator_id"=>	$creator_id
		];

		$flg = Db::table(getInfoManageTableName($tableIndex))->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 修改系统公告
	public function updateAnnounce(){
		$tableIndex = Request::instance()->post("tableIndex");
		$id = Request::instance()->post("id");
		$content = Request::instance()->post("content");
		$type = Request::instance()->post("type");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"content"	=>	$content,
			"type"		=>	$type,
			"creator_id"=>	$creator_id
		];

		$flg = Db::table(getInfoManageTableName($tableIndex))
		->where("id", $id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];

		echo json_encode($result);
	}

	// 创建留言信息 
	public function createMessage(){
		$tableIndex = Request::instance()->post("tableIndex");
		$content = Request::instance()->post("content");
		$is_anonymous = Request::instance()->post("is_anonymous");
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"content" 		=> $content,
			"is_anonymous"	=> $is_anonymous,
			"creator_id"	=> $creator_id
		];

		$flg = Db::table(getInfoManageTableName($tableIndex))->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 删除信息
	public function delete(){
		$tableIndex = Request::instance()->post("tableIndex");
		$id = Request::instance()->post("id");

		$flg = Db::table(getInfoManageTableName($tableIndex))
		->where("id", $id)->delete();
		$result = ["flg" => $flg];

		echo json_encode($result);
	}
}
?>