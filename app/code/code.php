<!-- // code.php  -->
<?php
    $MyConf["can_logM"]=false;
    $MyConf["can_log"]=false;
    require_once $ConfPath["mymodel"];
    // require_once "uploadcode.php";
    // echo $Paths[$Paths["now"]];
    @$codeid=$Paths[$Paths["now"]];
    loge2($codeid,"codeid");
    if($codeid){
        $codeData=MyModel::getInstance()->getCodeById($codeid)[0];
        $updata = MyModel::getInstance()->getUserByUserid($codeData["userid"]);
        $isfans = MyModel::getInstance()->isFans($codeData["userid"],$_COOKIE["userid"]);
        $isCollectCode = MyModel::getInstance()->isInCollectCodec($_COOKIE["userid"],$codeid);
    }else{

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/file/edit/edit.css" />
    <link rel="stylesheet" href="/file/css/main.css" />
    <title>Edit Code</title>
</head>
<body>
<style>
    .hidden{
        display:none;
    }
    .show{
        display:block;
    }
    .showInline{
        display:inline;
    }
    .leftBox{
        float:left;
        width: 640px;
        border-right:1px black solid;
    }
    .rightBox{
        float:left;
        width:319px;
    }
</style>
    <script>//初始化从mysql读取的数据
        var mysqlData;
        <?php
            if($codeid){
                echo 'mysqlData={';
                echo '"codeid":"'.$codeData["codeid"].'",';
                echo '"codename":"'.$codeData["codename"].'",';
                echo '"picid":"'.$codeData["picid"].'",';
                echo '"picpath":"'.$codeData["picpath"].'",';
                echo '"codecontent":`'.$codeData["codecontent"].'`,';
                echo '}';
            }
        ?>
    </script>
    <?php //网页头部条
        require $ConfPath["top"];
    ?>
    <div class="mainBox">
        <div class="leftBox">
            <!-- ==================显示部分 -->
            <div>
                <img id="pic" alt=""/>
                <canvas id="mycanvas"></canvas>
                <input id="loop" type="checkbox" />
            </div>

            <!-- ===================编辑部分 -->
            <div>
                <form action="/code/uploadcode" method="post" onkeydown="if(event.keyCode==13){return ;}">
                    <input id="codeid" type="hidden" name="codeid">
                    <label for="codename">特效名</label><input id="codename" name="codename" type="text" onkeydown="if(event.keyCode==13){return false;}">
                    <label for="codename">图片ID</label><input id="picid" type="text" name="picid" onkeydown="if(event.keyCode==13){return false;}"/>
                    <div id="argumentsBox">
                        
                    </div>
                    <textarea id="codeText" name="codecontent"></textarea>

                    <input type="button" onclick="userCode.RunCode();" value="运行代码"/>
                    <?php
                        if($codeid){
                            if($codeData["userid"]==$_COOKIE["userid"]){
                                echo '<input type="submit" name="type" value="修改">';
                                echo '<input type="submit" name="type" value="删除">';
                            }
                        }else{
                            echo '<input type="submit" name="type" value="添加">';
                        }
                    ?>
                </form>
            </div>
        </div>


        <div class="rightBox">
            <form action="/user/updatefans" method="post">
                <p>作者:
                    <a href="/user/info?userid=<?php echo $updata["userid"] ?>"> <?php echo $updata["nickname"];?> </a>
                    粉丝数:<?php echo $updata["fansnum"];?> 
                    <input type="hidden" name="upid" value="<?php echo $codeData["userid"]?>"/>
                    <input class="<?php echo !$isfans ? 'showInline' : 'hidden'?>"  type="submit" name="type" value="关注"> 
                    <input class="<?php echo $isfans ? 'showInline' : 'hidden'?>"  type="submit" name="type" value="取消关注"> 
                </p>
            </form>
            <p>上传时间: <?php echo date('Y-n-d   h:i:s A',intval($codeData["uploadtime"]));?></p>
            <form action="/code/collectcode" method="post">
                <p>收藏数: <?php echo $codeData["collectnum"] ?>        
                    <input type="hidden" name="codeid" value="<?php echo $codeData["codeid"]?>"/>
                    <input type="hidden" name="customname" value="<?php echo $codeData["codename"]?>"/>
                    <input class="<?php echo !$isCollectCode ? 'showInline' : 'hidden'?>" type="submit" name="type" value="收藏">
                    <input class="<?php echo $isCollectCode ? 'showInline' : 'hidden'?>" type="submit" name="type" value="取消收藏">
                </p>
            </form>

        </div>


    </div>
    
    <script src="/file/edit/edit.js"></script>
</body>
</html>