// pic 图片展示页<br/>

<?php 
    require_once APPROOT."/user/upload/pic.php";
    require_once $ConfPath["mymodel"];
    require_once $ConfPath["showpic"];

    class Info_Pic{
        var $myModel;
        var $picData;
        function Init(){
            $this->myModel=MyModel::getInstance();
        }
        function ShowPics(){
            $picDatas=$this->myModel->getPicByUserid($_GET["userid"]);
            ShowPic::showPics($picDatas);
        }
    }

    $info_Pic=new Info_Pic;
    $info_Pic->Init();
    $info_Pic->ShowPics();
?>


<?php
 
?>