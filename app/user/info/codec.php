// codec page
特效收藏页
<style>
    .codeBox{
        /* display: inline; */
        width:400px;
    }

    .code-picBox {
        float:left;
        width:50%;
    }
    .code-picBox img {
        width: 100%; 
        height: auto;
        max-width: 100%; 
        display: block;
    }
    .code-picBox canvas {
        width: 100%; 
        height: auto;
        max-width: 100%; 
        display: block;
    }

    .codeInfo{
        text-align: center;
    }
</style>
<div class="codeBigBox">
</div>
<?php 
    require_once $ConfPath["mymodel"];
    require_once $ConfPath["showpic"];
    // $MyConf["can_log"]=true;
    // $MyConf["can_logM"]=true;
    class Picc{
        var $myModel;
        var $picData;
        static function Init(){
            // $this->myModel=MyModel::getInstance();
            self::ShowCodes();
        }

        static function ShowCodes(){
            $codeDatas=MyModel::getInstance()->getCodeByUserid($_GET["userid"]);//todo 自己上传的code 改 收藏的code
            echo "<script> var mysqlData=[";
            for($i=0;$i<count($codeDatas);$i++){
                echo '{"codename":"'.$codeDatas[$i]["codename"].'",';
                echo '"codeid":"'.$codeDatas[$i]["codeid"].'",';
                $picData=MyModel::getInstance()->getPicByPicid($codeDatas[$i]["picid"]);
                echo '"picpath":\''.$picData[0]["picpath"].'\',';
                // echo '"picpath":"'.$codeDatas[$i]["picpath"].'",';
                echo '"codecontent":`'.$codeDatas[$i]["codecontent"].'`},';
            }
            echo "];</script>";
            echo '<script src="/file/edit_showcode/edit.js"></script>';
            return $codeDatas;
        }

    }
    Picc::Init();
    // $info_Pic->ShowPics();
?>