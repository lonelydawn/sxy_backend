<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


// 根据传入参数返回待查询表名称 适用于配置类表
function getConfigTableName($index){
	$tables = [
		"sxy_industry_type",
		"sxy_class_type",
		"sxy_course_type",
		"sxy_title_type",
		"sxy_role_type",
		"sxy_announce_type",
		"sxy_activity_type",
		"sxy_material_type",
		"sxy_account_type"
	];
	return $tables[$index];
}

// 返回制度管理相应数据库表
function getSystemManageTableName($index){
	$tables = [
		"sxy_regulation_info",
		"sxy_duty_info"
	];
	return $tables[$index];
}

// 返回宣传管理相应数据库表
function getPropagateManageTableName($index){
	$tables = [
		"sxy_company_poster",
		"sxy_activity_poster",
		"sxy_course_poster",
		"sxy_excellent_student"
	];
	return $tables[$index];
}

// 返回信息管理相应数据库表
function getInfoManageTableName($index){
	$tables = [
		"sxy_announce_info",
		"sxy_message_record"
	];
	return $tables[$index];
}