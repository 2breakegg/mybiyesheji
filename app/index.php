
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/file/css/main.css">
    <title>蛋蛋在线js图像特效分享站</title>
    <style>
        .headline2{
            font-size:20px;
            background:#ccc;
            padding:5px;
        }
        #searchBar{
            right: 10px;
            position: absolute;
            /* float: right; */
            top: 10px;
        }
    </style>
</head>
<body>
<?php 

    require_once $ConfPath["top"];
    require_once $ConfPath["showcode"];
    require_once $ConfPath["showpic"];

    $MyConf["can_log"]=true;
    $MyConf["can_logM"]=true;

    $picdata=MyModel::getInstance()->getPicsAny();
    $codedata=MyModel::getInstance()->getCodesAny();
?>
    <!-- <h1>index.php</h1> -->
    <div class="mainBox">
        <h1>蛋蛋在线js图像特效分享站</h1>
        <div id="searchBar">
            <form action="/search/" method="GET">
                <input type="text" name="keyword"/>
                <input type="submit" value="搜索" />
            </form>
        </div>
        <div class="picBigBox">
            <div class="headline2">图片</div>
            <?php
                ShowPic::showPics($picdata);
            ?>
        </div>
        <div class="codeBigBox">
            <div class="headline2">特效</div>
            <?php
                ShowCode::showCodes($codedata);
            ?>
        </div>
    </div>
    
</body>
</html>
