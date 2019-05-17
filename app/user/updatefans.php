//updatefans.php
<?php
    require_once $ConfPath["top"];
    require_once $ConfPath["mymodel"];
    $MyConf["can_log"]=true;
    $MyConf["can_logM"]=true;
    class UploadFans{
        static function init(){
            $type=$_POST["type"];
            $upid=$_POST["upid"];
            $fansid=$_COOKIE["userid"];

            if($type=="关注"){
                self::subscribe($upid,$fansid);
            }else if($type=="取消关注"){
                self::unsubscribe($upid,$fansid);
            }
        }

        static function subscribe($upid,$fansid){
            if(MyModel::getInstance()->subscribe($upid,$fansid)){
                echo "关注成功";
            }else{
                echo "关注失败";
            }
        }

        static function unsubscribe($upid,$fansid){
            //todo
            loge2($upid." ".$fansid,"upid , fansid");
            if(MyModel::getInstance()->unsubscribe($upid,$fansid)){
                echo "取消关注成功";
            }else{
                echo "取消关注失败";
            }
        }

    }

    UploadFans::init();
?>