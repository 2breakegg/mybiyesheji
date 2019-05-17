<?php
    require_once $ConfPath["top"];
    require_once $ConfPath["mymodel"];
    // $MyConf["can_log"]=true;
    // $MyConf["can_logM"]=true;
    class CollectPic{
        static function init(){
            $type=$_POST["type"];
            $userid=$_COOKIE["userid"];
            $picid=$_POST["picid"];
            if($type=="收藏"){
                $customname=$_POST["customname"];
                self::collectPic_($userid,$picid,$customname);
            }else if($type=="取消收藏"){
                self::deleteCollectPic($userid,$picid);
            }
        }

        static function collectPic_($userid,$picid,$customname){
            if(MyModel::getInstance()->collectPic($userid,$picid,$customname)){
                echo "收藏成功";
            }else{
                echo "收藏失败";
            }
        }

        static function deleteCollectPic($userid,$picid){
            if(MyModel::getInstance()->deleteCollectPic($userid,$picid)){
                echo "取消收藏成功";
            }else{
                echo "取消收藏失败";
            }
        }
    }

    CollectPic::init();
?>