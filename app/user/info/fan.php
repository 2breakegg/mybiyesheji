<!-- // fan  粉丝页 -->
<table style="padding:20px;margin: auto;">
<?php
    // $MyConf["can_logM"]=true;
    // $MyConf["can_log"]=true;
    require_once $ConfPath["mymodel"];
    class Fan{
        static function init(){
            $upid=$_GET["userid"];
            self::show($upid);
        }
        static function show($upid){
            $data=MyModel::getInstance()->getFansByUpid($upid);
            logvar($data);
            for($i=0; $i<count($data); $i++){
                $fansid=$data[$i]['userid'];
                $nickname=$data[$i]['nickname'];
                $fansnum=$data[$i]['fansnum'];
                // echo "<p><a href='/user/info?userid={$fansid}'>{$nickname}</a></p>";
                echo "<tr>";
                echo    "<td style='width:200px'><a href='/user/info?userid={$fansid}'>{$nickname}</a></td>";
                echo    "<td>粉丝数 ：{$fansnum}</td>";
                // echo    "<td>关注日期 ：".date('Y-n-d  ',intval($codeData["uploadtime"]))."</td>";
                echo "</tr>";
            }
        }
    }

    Fan::init();
?>
</table>


<!-- <table style="padding:20px;margin: auto;">
    <tr>
        <td style="width:200px"><a href='/user/info?userid={$fansid}'>小Q111</a></td>
        <td>关注日期 ：2017-10-10</td>
    </tr>
    <tr>
        <td><a href='/user/info?userid={$fansid}'>小Q</a></td>
        <td>2017-10-10</td>
    </tr>
</table> -->
