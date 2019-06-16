<?php
    require_once $ConfPath["mymodel"];
    class Codereply{
        static function init(){

        }
        static function showCodereply($codeid){
            $CodereplyDatas=MyModel::getInstance()->getCodereplyByCodeid($codeid);
            for($i=0;$i<count($CodereplyDatas);$i++){
                self::darwCodereply($CodereplyDatas[$i]);
            }
        }
        static function darwCodereply($CodereplyData){
            $nickname=MyModel::getInstance()->getNicknameByUserid($CodereplyData["userid"]);
            $content=$CodereplyData["content"];
            $time=date('Y-n-d   h:i A',intval($CodereplyData["time"]));
            echo'<div class="replyUnity">';
            echo    '<div class="replyUser">';
            echo        "<a href='{$nickname}'>{$nickname}</a><br>";
            echo        "<span class='replyTime'>{$time}</span>";
            echo    '</div>';
            echo    '<div class="replyContent">';
            echo        "{$content}";
            echo    '</div>';
            echo    '<div style="clear:both"></div>';
            echo'</div>';
        }
    }
?>
<style>
    .headline2 {
        font-size: 20px;
        background: #ccc;
        padding: 5px;
    }
    .replyUnity{
        margin: 5px;
        padding-bottom:10px;
        border-bottom: 2px #cecece solid;
    }
    .replyUser{
        width:120px;
        float:left;
    }
    .replyContent{
        padding-left:10px;
        width:500px;
        float:left;
    }
    .replyTime{
        font-size:9px;
    }
</style>
<div>
    <div class="headline2"> 留言</div>
    <form action="./addcodereply.php" method="post">
        <!-- <input type="text" value="javascript:location.href"> -->
        <input type="hidden" name="codeid" value="<?php echo $codeid; ?>">
        <textarea name="content" id="" cols="80" rows="4"></textarea>
        <input type="submit" value="提交">
    </form>

    <?php
        Codereply::showCodereply($codeid);
    ?>

</div>
