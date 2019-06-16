<!-- //idol 关注页 -->
<table style="padding:20px;margin: auto;">
<?php
    // $MyConf["can_logM"]=true;
    // $MyConf["can_log"]=true;
    require_once $ConfPath["mymodel"];
    class Idol{
        static function init(){
            $fansid=$_GET["userid"];
            self::show($fansid);
        }

        static function show($fansid){
            $data=MyModel::getInstance()->getUpsByFansid($fansid);
            logvar($data);
            for($i=0; $i<count($data); $i++){
                $upid=$data[$i]['userid'];
                $nickname=$data[$i]['nickname'];
                $fansnum=$data[$i]['fansnum'];
                // echo "<p><a href='/user/info?userid={$fansid}'>{$nickname}</a></p>";
                echo "<tr>";
                echo    "<td style='width:200px'><a href='/user/info?userid={$upid}'>{$nickname}</a></td>";
                echo    "<td>粉丝数 ：{$fansnum}</td>";
                // echo    "<td>关注日期 ：".date('Y-n-d  ',intval($codeData["uploadtime"]))."</td>";
                echo "</tr>";
            }
        }
    }

    Idol::init();
?>
</table>