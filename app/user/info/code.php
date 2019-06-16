<!-- //code page -->
<!-- //特效页 -->
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
    .codeBigBox{
        width:420px;
        margin:auto;
    }
</style>
<?php if($isSelf){?><a href="/code">添加新特效</a><?php }?>

<div class="codeBigBox"></div>

<?php
    require_once $ConfPath["mymodel"];

    class Info_Code{
        var $myModel;
        var $codeDatas;
        function Init(){
            $this->myModel=MyModel::getInstance();
        }
        function ShowCodes(){
            $codeDatas=$this->myModel->getCodeByUserid($_GET["userid"]);
            echo "<script> var mysqlData=[";
            for($i=0;$i<count($codeDatas);$i++){
                echo '{"codename":"'.$codeDatas[$i]["codename"].'",';
                echo '"codeid":"'.$codeDatas[$i]["codeid"].'",';
                $picData=$this->myModel->getPicByPicid($codeDatas[$i]["picid"]);
                echo '"picpath":\''.$picData[0]["picpath"].'\',';
                // echo '"picpath":"'.$codeDatas[$i]["picpath"].'",';
                echo '"codecontent":`'.$codeDatas[$i]["codecontent"].'`},';
            }
            echo "];</script>";
            echo '<script src="/file/edit_showcode/edit.js"></script>';
            return $codeDatas;
        }
    }

    $info_Code=new Info_Code;
    $info_Code->Init();
    $info_Code->ShowCodes();
    // echo "<script> ";
    // echo "var mysqlData=".json_encode($info_Code->ShowCodes());
    // echo "</script>";
?>
