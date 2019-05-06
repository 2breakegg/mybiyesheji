<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/file/css/main.css" type="text/css">
    <link rel="stylesheet" href="/file/css/userinfo.css" type="text/css">
    <title>Document</title>
</head>
<body>
<?php
    if(!isset($_GET['userid'])){
        if(!isset($_COOKIE['userid'])){
            header("Location: ".$_SERVER['HTTP_HOST']."/user/login");
            loge2("未登录 未指定uierid, 跳到登录页");
        }
        header("Location: ?userid=".$_COOKIE['userid']);
        loge2($_SERVER['HTTP_HOST']."/user?userid=".$_COOKIE['userid']);
        loge2("未指定userid, 跳到自己的页面");
    };
    $ConfPath["top"];
?>
    <div class="mainBox">
        <div class="tabBox">
            <a id="infoTab" href="javascript:getUrl('info')"><p>个人信息</p></a>
            <a id="picTab" href="javascript:getUrl('pic')"><p>图片</p></a>
            <a id="codeTab" href="javascript:getUrl('code')"><p>特效</p></a>
            <a id="piccTab" href="javascript:getUrl('picc')"><p>收藏图片</p></a>
            <a id="codecTab" href="javascript:getUrl('codec')"><p>收藏特效</p></a>
            <a id="idolTab" href="javascript:getUrl('idol')"><p>关注</p></a>
            <a id="fanTab" href="javascript:getUrl('fan')"><p>粉丝</p></a>
        </div>
        <div id="content" class="content">
            <?php
                if(isset($_GET['page'])){
                    require APPROOT."/user/info/{$_GET['page']}.php";
                    // echo "this is {$_GET['page']} page";
                }else{
                    require APPROOT."/user/info/info.php";
                    // echo "this is info page";
                }
            ?>
        </div>
        <div style="clear:both"></div>
    </div>
    <script src="/file/js/info.js"></script>
</body>
</html>
