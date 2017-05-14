<?php
namespace app\mis\controller;
use think\Controller;
use think\Request;
use think\Db;

class CollegePropagate extends Controller{
	public function _empty(){
		$msg = ["msg" => "请求错误!"];
		echo json_encode($msg);
	}

	// 模糊查询
	public function search(){
		$txt = urldecode(Request::instance()->header("txt"));
		$pageSize = Request::instance()->header("pageSize");
		$pageNum = Request::instance()->header("pageNum");
		$tableIndex = Request::instance()->header("tableIndex");

		// $txt = '';
		// $pageSize = 8;
		// $pageNum = 0;
		// $tableIndex = 3;

		$result = [
			"items" => [],
			"count" => 0
		];

		// 优秀学子 匹配姓名, 其他宣传 匹配标题
		if($tableIndex != 3){
			// 获取所有条目
			$tmp = Db::table(getPropagateManageTableName($tableIndex))
				->where("title", "like", "%".$txt."%")
				->order('id desc')
				->select();
			// 获取分页条目
			for($index = 0; $index<$pageSize; $index++)
				if($pageSize*$pageNum + $index < sizeof($tmp))
					$result['items'][$index]  = $tmp[$pageSize*$pageNum +$index];
			// 获得总条目数
			$result["count"] = sizeof($tmp);
		}else {
			// 模糊匹配查询内容, 获取匹配学生编号数组
			$data = Db::table("sxy_people_info")
				->where([
					"name" => ["like", "%".$txt."%"],
					"type" => "学生"
				])->select();
			$index = 0;
			$items = array();
			// 检索优秀学子数组, 如果查询匹配学生在优秀学子数组中,则加入结果数组以待返回
			for($i = 0; $i<sizeof($data); $i++){
				// 学生个体
				$tmp = Db::table(getPropagateManageTableName($tableIndex))
					->where("student_id",$data[$i]["id"])
					->order('id desc')
					->limit($pageNum*$pageSize, $pageSize)
					->find();
				if(!is_null($tmp)) {
					$tmp['student_name'] = $data[$i]['name'];
					$items[$index++] = $tmp;
				}
			}
			// 获取分页条目
			for($index = 0; $index<$pageSize; $index++)
				if($pageSize*$pageNum + $index < sizeof($items))
					$result['items'][$index] = $items[$pageSize*$pageNum +$index];
			// 获取总条目数
			$result['count'] = sizeof($items);
		}
		echo json_encode($result);
	}
}


?>