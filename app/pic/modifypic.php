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
        width:299px;
        padding:10px;
    }
</style>
<?php
    require_once $ConfPath["mymodel"];
    // $MyConf["can_logM"]=true;
    // $MyConf["can_log"]=true;
    $picdata = MyModel::getInstance()->getPicByPicid($picid)[0];
    $updata = MyModel::getInstance()->getUserByUserid($picdata["userid"]);
    $isfans = MyModel::getInstance()->isFans($picdata["userid"],$_COOKIE["userid"]);
    $isCollectPic = MyModel::getInstance()->isInCollectPicc($_COOKIE["userid"],$picid);
    logvar($isCollectPic,"isCollectPic");
    logvar($picdata,"from mysql:");
?>

<div class="leftBox">
    <!-- 游客 浏览图片 -->
        <div class="<?php echo $_COOKIE["userid"]!=$picdata["userid"] ? "show" : "hidden" ?>">
            <img src="<?php echo $picdata["picpath"]?>" alt="">
            <p>图片名称: <?php echo $picdata["picname"]?></p>
        </div>
    <!-- 游客 end -->

    <!-- 上传者 -->
        <!-- 修改,删除图片 -->
        <form class="<?php echo $_COOKIE["userid"]==$picdata["userid"] ? "show" : "hidden" ?>" action="/pic/uploadpic" method="post" enctype="multipart/form-data">
            <input type="hidden" name="picid" value="<?php echo $picdata["picid"]?>"/>
            <img src="<?php echo $picdata["picpath"]?>" alt="">
            <br/>
            <label for="picname">图片名称:</label> 
            <input id="picname" name="picname" type="text" value="<?php echo $picdata["picname"]?>" >
            <input type="submit" name="type" value="修改名称"/>
            <br/>
            <input type="submit" name="type" value="删除图片"/>
        </form>
    <!-- 上传者 end -->

    <!-- 留言 -->
        <?php require_once APPROOT."/pic/picreply.php";?>
    <!-- 留言 -->
</div>

<div class="rightBox">
    <form action="/user/updatefans" method="post">
        <p>作者:
            <a href="/user/info?userid=<?php echo $updata["userid"] ?>"> <?php echo $updata["nickname"];?> </a>
            粉丝数:<?php echo $updata["fansnum"];?> 
            <input type="hidden" name="upid" value="<?php echo $picdata["userid"]?>"/>
            <input class="<?php echo !$isfans ? 'showInline' : 'hidden'?>"  type="submit" name="type" value="关注"> 
            <input class="<?php echo $isfans ? 'showInline' : 'hidden'?>"  type="submit" name="type" value="取消关注"> 
        </p>
    </form>
    <p>上传时间: <?php echo date('Y-n-d   h:i:s A',intval($picdata["uploadtime"]));?></p>
    <form action="/pic/collectpic" method="post">
        <p>收藏数: <?php echo $picdata["collectnum"] ?>        
            <input type="hidden" name="picid" value="<?php echo $picdata["picid"]?>"/>
            <input type="hidden" name="customname" value="<?php echo $picdata["picname"]?>"/>
            <input class="<?php echo !$isCollectPic ? 'showInline' : 'hidden'?>" type="submit" name="type" value="收藏">
            <input class="<?php echo $isCollectPic ? 'showInline' : 'hidden'?>" type="submit" name="type" value="取消收藏">
        </p>
    </form>
</div>
