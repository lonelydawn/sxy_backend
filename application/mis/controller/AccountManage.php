<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class AccountManage extends Controller{
	public function _empty(){
		$msg=["msg"=>"请求错误!"];
		echo json_encode($msg);
	}

	// 获取资产总额
	public function getSum(){
		$income = Db::table("sxy_account_info")->where("action","收入")->sum("val");
		$outcome = Db::table("sxy_account_info")->where("action","支出")->sum("val");
		$result = ["sum" => $income-$outcome];
		echo json_encode($result);
	}

	// 查询资产
	public function getPage(){
		$pageNum = Request::instance()->header("pageNum");
		$pageSize = Request::instance()->header("pageSize");
		$keyword = urldecode(Request::instance()->header("keyword"));

		$count = Db::table("sxy_account_info")
			->where("name|type","like","%".$keyword."%")
			->count();

		$data = Db::table("sxy_account_info")
			->where("name|type","like","%".$keyword."%")
			->order('id desc')
			->limit($pageNum*$pageSize, $pageSize)->select();

		// 查询创建者名称
		for($i=0; $i<sizeof($data); $i++){
			$tmp = Db::table("sxy_people_info")
				->where("id", $data[$i]["creator_id"])->find();
			if(!is_null($tmp)) $data[$i]["creator_name"] = $tmp["name"];
		}

		$result = ["items" => $data, "count" => $count];
		echo json_encode($result);
	}

	// 创建资产
	public function create(){
		$name = Request::instance()->post("name");
		$val = Request::instance()->post("val");
		$type = Request::instance()->post("type");
		$action = Request::instance()->post("action"); 
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"name" 		=> $name,
			"val" 		=> $val,
			"type" 		=> $type, 
			"action" 	=> $action, 
			"creator_id"=> $creator_id
		];
		$flg = Db::table("sxy_account_info")->insert($data);
		$result = ["flg" => $flg];

		echo json_encode($result);
	}

	// 修改资产
	public function update(){
		$id = Request::instance()->post("id");
		$name = Request::instance()->post("name");
		$val = Request::instance()->post("val");
		$type = Request::instance()->post("type");
		$action = Request::instance()->post("action"); 
		$creator_id = Request::instance()->post("creator_id");

		$data = [
			"name" 		=> $name,
			"val" 		=> $val,
			"type" 		=> $type, 
			"action" 	=> $action, 
			"creator_id"=> $creator_id
		];
		$flg = Db::table("sxy_account_info")->where("id",$id)->update($data);
		$result = $flg == 1 ? ["flg" => 1]: ["flg" =>0 , "msg" =>"数据库无改动!"];
		echo json_encode($result);
	}

	// 删除资产
	public function delete(){
		$id = Request::instance()->post("id");
		$flg = Db::table("sxy_account_info")->where('id',$id)->delete();
		$result = ["flg" => $flg];
		echo json_encode($result);
	}

	// 根据收支类型获取各大类收支金额
	public function getAccountByType(){
		$type = urldecode(Request::instance()->header("type"));
		$begin_date = urldecode(Request::instance()->header("beginDate"));
		$end_date = urldecode(Request::instance()->header("endDate"));

		// $data = DB::table("sxy_account_info")
		// ->field("type as name,sum(val) as value")
		// ->where("action", $type)
		// ->where("create_time", "between", [$begin_date, $end_date])
		// ->group("type")
		// ->select();

		$data = DB::table("sxy_account_info")
		->field("type as name,sum(val) as value")
		->where(["action" => $type, "create_time" => ["between", [$begin_date, $end_date]]])
		->group("type")
		->select();

		echo json_encode($data);
	}
}
?>