<?php
    require_once $ConfPath["top"];
    require_once $ConfPath["mymodel"];
    // $MyConf["can_log"]=true;
    // $MyConf["can_logM"]=true;
    class CollectCode{
        static function init(){
            $type=$_POST["type"];
            $userid=$_COOKIE["userid"];
            $codeid=$_POST["codeid"];
            if($type=="收藏"){
                $customname=$_POST["customname"];
                self::collectCode_($userid,$codeid,$customname);
            }else if($type=="取消收藏"){
                self::deleteCollectCode($userid,$codeid);
            }
        }

        static function collectCode_($userid,$codeid,$customname){
            if(MyModel::getInstance()->collectCode($userid,$codeid,$customname)){
                echo "收藏成功";
            }else{
                echo "收藏失败";
            }
        }

        static function deleteCollectCode($userid,$codeid){
            if(MyModel::getInstance()->deleteCollectCode($userid,$codeid)){
                echo "取消收藏成功";
            }else{
                echo "取消收藏失败";
            }
        }
    }

    CollectCode::init();
?>