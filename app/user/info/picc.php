<!-- // picc 收藏图片展示页 -->
<br/>
<?php 
    require_once $ConfPath["mymodel"];
    require_once $ConfPath["showpic"];
    // $MyConf["can_log"]=true;
    // $MyConf["can_logM"]=true;
    class Picc{
        var $myModel;
        var $picData;
        function Init(){
            // $this->myModel=MyModel::getInstance();
            $this->ShowPics();
        }
        function ShowPics(){
            $picDatas=MyModel::getInstance()->showCollectPic($_GET["userid"]);
            logvar($picDatas,"picDatas");
            ShowPic::showPics($picDatas);
        }
    }

    $picc=new Picc;
    $picc->Init();
    // $info_Pic->ShowPics();
?>