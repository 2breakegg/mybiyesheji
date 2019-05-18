// fan  粉丝页
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
                echo "<p><a href='/user/info?userid={$fansid}'>{$nickname}</a></p>";
            }
        }
    }

    Fan::init();
?>