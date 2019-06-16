<?php
    require_once $ConfPath["mymodel"];

    class AddPicreply{
        static function add($userid,$picid,$content){

            if(MyModel::getInstance()->addPicreply($userid,$picid,$content)){
                echo "留言成功";
            }else{
                echo "留言失败";
            }
        }
    }

    $userid=$_COOKIE["userid"];
    $picid=$_POST["picid"];
    $content=$_POST["content"];
    AddPicreply::add($userid,$picid,$content);
?>