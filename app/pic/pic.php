<!-- //pic.php -->
<?php
    // $MyConf["can_log"]=true;
    // $MyConf["can_logM"]=true;
    require_once $ConfPath["mymodel"];
    @$picid=$Paths[$Paths["now"]];
    if($picid){
        // $codeData=MyModel::getInstance()->getCodeById($codeid)[0];
        loge2($picid,"显示图片");
    }else{
        loge2($picid,"新增图片");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/file/edit/edit.css" />
    <link rel="stylesheet" href="/file/css/main.css" />
    <title>Edit Code</title>
</head>
<body>
    <?php //网页头部条
        require $ConfPath["top"];
    ?>
    <div class="mainBox">
        
    <?php
        if($picid){
            require_once APPROOT."/pic/modifypic.php";
        }else{
            require_once APPROOT."/pic/newpic.php";
        }
    ?>

    </div>


</body>
</html>