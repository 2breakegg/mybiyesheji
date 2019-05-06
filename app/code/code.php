// code.php
<?php
    require_once $ConfPath["mymodel"];
    // echo $Paths[$Paths["now"]];
    logvar($Paths,'$Paths',1);
    $codeid=$Paths[$Paths["now"]];

    $codeData=MyModel::getInstance()->getCodeById($codeid)[0];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/file/edit/edit.css" />
    <title>Edit Code</title>
</head>
<body>
    <!-- ==================显示部分 -->
    <div>
        <img id="pic" src="<?php echo $codeData["picpath"] ?>" alt=""/>
        <canvas id="mycanvas"></canvas>
        <input id="loop" type="checkbox" />
    </div>

    <!-- ===================编辑部分 -->
    <div>
        <form method="post" onkeydown="if(event.keyCode==13){return false;}">
        <label for="codeName">特效名</label><input id="codeName" name="codeName" type="text">
            <input type="hidden" name="">
            <div id="argumentsBox">
                
            </div>
            <textarea id="codeText"></textarea>

            <span></span> 
            <input type="submit" name="add" value="添加">
            <!-- <input type="submit" name="modify" value="修改"> -->
        </form>
    </div>
    <script>
        var mysqlData={<?php
            echo '"codename":"'.$codeData["codename"].'",';
            echo '"picpath":"'.$codeData["picpath"].'",';
            echo '"codecontent":`'.$codeData["codecontent"].'`,';
        ?>};
    </script>
    <script src="/file/edit/edit.js"></script>
</body>
</html>