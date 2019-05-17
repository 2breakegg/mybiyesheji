//idol 关注页
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
                echo "<p><a href='/user/info?userid={$upid}'>{$nickname}</a></p>";
            }
        }
    }

    Idol::init();
?>
