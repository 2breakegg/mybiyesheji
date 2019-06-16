<?php
    require_once $ConfPath["mymodel"];

    class AddCodereply{
        static function add($userid,$codeid,$content){

            if(MyModel::getInstance()->addCodereply($userid,$codeid,$content)){
                echo "留言成功";
            }else{
                echo "留言失败";
            }
        }
    }

    $userid=$_COOKIE["userid"];
    $codeid=$_POST["codeid"];
    $content=$_POST["content"];
    AddCodereply::add($userid,$codeid,$content);
?>