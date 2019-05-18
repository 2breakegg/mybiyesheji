<?php 
    $showAllWarning=true;
    date_default_timezone_set('Asia/Shanghai');
    $MyConf=[
        "md5"=>false,
        "can_log"=>false,
        "can_logM"=>false,
        "can_logForce"=>0,  //1 一定log ,-1 禁止log, 0 由$force 和 can_log判断
        "can_logMForce"=>0,
        "mysql"=>[
            "db_name"        => "mybiyesheji",
            "mysql_username" => "root",
            "mysql_password" => "123456",         //服务器端"mysqlroot"
            "server_name"    => "localhost",
        ]
    ];

    $ConfPath=[
        "404"=>WWWROOT."/404.html",
        ""=>APPROOT."/index.php",
        "mymodel"=>APPROOT."/model/mymodel.php",

        "top"=>APPROOT."/view/require/top.php",
        "showpic"=>APPROOT."/view/require/showpic.php",
        "showcode"=>APPROOT."/view/require/showcode.php",
        "showuser"=>APPROOT."/view/require/showuser.php",

        "user"=>APPROOT."/user/route.php",
        "code"=>APPROOT."/code/route.php",
        "pic"=>APPROOT."/pic/route.php",
        "file"=>APPROOT."/file/route.php",
        "search"=>APPROOT."/search/search.php",
    ];
?>