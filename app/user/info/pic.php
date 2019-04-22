// pic 图片展示页<br/>

<?php 
    require_once APPROOT."/user/upload/pic.php";
    require_once $ConfPath["mymodel"];

    class Info_Pic{
        var $myModel;
        var $picData;
        function Init(){
            $this->myModel=MyModel::getInstance();
        }
        function ShowPics(){
            $this->myModel->getPicByUserid($_GET["userid"]);

        }
    }

    $info_Pic=new Info_Pic;
    $info_Pic->Init();
    $info_Pic->ShowPics();
?>

<br/>
<br/>
<br/>
<br/>

<?php
 
?>