<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------




return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    'login'		=> 'mis/login/login',

    "homepage/getCourseInfo"  => "mis/homepage/getCourseInfo",
    "homepage/getPropagate"  => "mis/homepage/getPropagate",

    "selfInfo/getStudent" => 'mis/selfInfo/getStudent',
    "selfInfo/getTeacher" => 'mis/selfInfo/getTeacher',
    "selfInfo/updateStudent" => 'mis/selfInfo/updateStudent',
    "selfInfo/updateTeacher" => 'mis/selfInfo/updateTeacher',
    "selfInfo/updateStudentPhoto" => 'mis/selfInfo/updateStudentPhoto',
    "selfInfo/updateTeacherPhoto" => 'mis/selfInfo/updateTeacherPhoto',
    "selfInfo/updatePassword" => 'mis/selfInfo/updatePassword',

    "collegePropagate/search" => 'mis/collegePropagate/search',
    
    "courseConstruct/getStudentCoursePage" => 'mis/courseConstruct/getStudentCoursePage',
    "courseConstruct/getTeacherCoursePage" => 'mis/courseConstruct/getTeacherCoursePage',
    "courseConstruct/getTeacherCourseTable" => 'mis/courseConstruct/getTeacherCourseTable',
    "courseConstruct/getResource" => 'mis/courseConstruct/getResource',
    "courseConstruct/uploadResource" => 'mis/courseConstruct/uploadResource',
    "courseConstruct/getAbsenceRecordPage" => 'mis/courseConstruct/getAbsenceRecordPage',
    
    "dailySystem/getAll" => 'mis/dailySystem/getAll',
    "leaderDuty/getAll" => 'mis/leaderDuty/getAll',
    
    'userManage/getAllTeachers' => 'mis/userManage/getAllTeachers',
    'userManage/getAllStudents' => 'mis/userManage/getAllStudents',
    'userManage/create' => 'mis/userManage/create',
    'userManage/search' => 'mis/userManage/search',
    'userManage/update' => 'mis/userManage/update',
    'userManage/delete' => 'mis/userManage/delete',

    'studentManage/getPage' => 'mis/studentManage/getPage',
    'studentManage/update' => 'mis/studentManage/update',

    'teacherManage/getPage' => 'mis/teacherManage/getPage',
    'teacherManage/update' => 'mis/teacherManage/update',

    'classManage/getClassType' => 'mis/classManage/getClassType',
    'classManage/getAllClass' => 'mis/classManage/getAllClass',
    'classManage/getPage' => 'mis/classManage/getPage',
    'classManage/create' => 'mis/classManage/create',
    'classManage/update' => 'mis/classManage/update',
    'classManage/delete' => 'mis/classManage/delete',

    'courseManage/getCourseType' => 'mis/courseManage/getCourseType',
    'courseManage/getAllCourses' => 'mis/courseManage/getAllCourses',
    'courseManage/getPage' => 'mis/courseManage/getPage',
    'courseManage/create' => 'mis/courseManage/create',
    'courseManage/update' => 'mis/courseManage/update',
    'courseManage/delete' => 'mis/courseManage/delete',
    
    'courseDistribute/distribute' => 'mis/courseDistribute/distribute',
    'courseDistribute/getDistribution' => 'mis/courseDistribute/getDistribution',
    'courseDistribute/deleteDistribution' => 'mis/courseDistribute/deleteDistribution',

    'absenceManage/getPage' => 'mis/absenceManage/getPage',
    'absenceManage/create' => 'mis/absenceManage/create',
    'absenceManage/update' => 'mis/absenceManage/update',
    'absenceManage/delete' => 'mis/absenceManage/delete',
    'absenceManage/getAbsenceByCourse' => 'mis/absenceManage/getAbsenceByCourse',
    
    "propagateManage/getPage" => 'mis/propagateManage/getPage',
    "propagateManage/getTotalItem" => 'mis/propagateManage/getTotalItem',
    "propagateManage/getCurrent" => 'mis/propagateManage/getCurrent',
    "propagateManage/createCompany" => 'mis/propagateManage/createCompany',
    "propagateManage/createActivity" => 'mis/propagateManage/createActivity',
    "propagateManage/createCourse" => 'mis/propagateManage/createCourse',
    "propagateManage/createStudent" => 'mis/propagateManage/createStudent',
    "propagateManage/updateCompany" => 'mis/propagateManage/updateCompany',
    "propagateManage/updateActivity" => 'mis/propagateManage/updateActivity',
    "propagateManage/updateCourse" => 'mis/propagateManage/updateCourse',
    "propagateManage/updateStudent" => 'mis/propagateManage/updateStudent',
    "propagateManage/delete" => 'mis/propagateManage/delete',

    "systemManage/create" => 'mis/systemManage/create',
    "systemManage/delete" => 'mis/systemManage/delete',

    'accountManage/getSum' => 'mis/accountManage/getSum',
    'accountManage/getPage' => 'mis/accountManage/getPage',
    'accountManage/create' => 'mis/accountManage/create',
    'accountManage/update' => 'mis/accountManage/update',
    'accountManage/delete' => 'mis/accountManage/delete',
    'accountManage/getAccountByType' => 'mis/accountManage/getAccountByType',

    "authorityManage/get" => 'mis/authorityManage/get',
    "authorityManage/update" => 'mis/authorityManage/update',

    'infoManage/getAnnounceTypes' => 'mis/infoManage/getAnnounceTypes',
    'infoManage/getPage' => 'mis/infoManage/getPage',
    'infoManage/createAnnounce' => 'mis/infoManage/createAnnounce',
    'infoManage/updateAnnounce' => 'mis/infoManage/updateAnnounce',
    'infoManage/createMessage' => 'mis/infoManage/createMessage',
    'infoManage/delete' => 'mis/infoManage/delete',

    'configManage/getCurrent' => 'mis/configManage/getCurrent',
    'configManage/create' => 'mis/configManage/create',

];