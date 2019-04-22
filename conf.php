<?php 
    $showAllWarning=true;
    date_default_timezone_set('Asia/Shanghai');
    $MyConf=[
        "md5"=>false,
        "can_log"=>true,
    ];

    $ConfPath=[
        "404"=>WWWROOT."/404.html",
        ""=>APPROOT."/index.php",
        "mymodel"=>APPROOT."/model/mymodel.php",
        "top"=>APPROOT."/view/require/top.php",
        "showpic"=>APPROOT."/view/require/showpic.php",
        "user"=>APPROOT."/user/route.php",
        "file"=>APPROOT."/file/route.php"
    ];
?>