<?php 
    $showAllWarning=true;
    date_default_timezone_set('Asia/Shanghai');
    $MyConf=[
        "md5"=>false,
        "can_log"=>false,
        "can_logM"=>true,
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
        "user"=>APPROOT."/user/route.php",
        "code"=>APPROOT."/code/route.php",
        "file"=>APPROOT."/file/route.php"
    ];
?>