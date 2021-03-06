<style>
    .codeBox{
        /* display: inline; */
        width:400px;
        float:left;
        margin:10px;
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
<?php
    require_once $ConfPath["mymodel"];

    class ShowCode{
        static function showCodes($codeDatas){
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
        }
    }

?>
