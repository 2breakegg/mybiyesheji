// uploadcode.php

<?php
require_once $ConfPath["mymodel"];
class UploadCode{
    function Init(){
        @$type=$_POST["type"];
        if( !isset($type)){
            return;
        }else if( $type == "添加"){
            $this->addNewCode();
        }else if( $type == "修改"){
            $this->modifyCode();
        }
    }
    function addNewCode(){
        echo "addNewCode";
        $codename=$_POST["codename"];
        $codecontent=$_POST["codecontent"];
        $userid=$_COOKIE["userid"];
        $picid=$_POST["picid"];
        if(MyModel::getInstance()->addCode($codename,$codecontent,$userid,$picid)){
            echo "上传成功";
        }else{
            echo "上传失败";
        }
        // MyModel::getInstance()->get1Result("code",[""])
    }
    function modifyCode(){
        echo "modifyCode";
        $codeid=$_POST["codeid"];
        $codename=$_POST["codename"];
        $codecontent=$_POST["codecontent"];
        $userid=$_COOKIE["userid"];
        $picid=$_POST["picid"];
        if(MyModel::getInstance()->modifyCode($codeid,$codename,$codecontent,$userid,$picid)){
            echo "修改成功";
        }else{
            echo "修改失败";
        }
    }
}
header('Content-type: text/plain');

(new UploadCode())->Init();
?>