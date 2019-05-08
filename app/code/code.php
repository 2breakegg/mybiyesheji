// code.php 
<?php
    $MyConf["can_logM"]=false;
    require_once $ConfPath["mymodel"];
    // require_once "uploadcode.php";
    // echo $Paths[$Paths["now"]];
    $codeid=$Paths[$Paths["now"]];
    if($codeid){
        $codeData=MyModel::getInstance()->getCodeById($codeid)[0];
    }else{

    }
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
    <script>
var mysqlData={"codeid":"0","codename":"默认","picid":"0","picpath":"/file/pic/0.png","codecontent":`var userField = {
    size:{type:"num",val:5},
    color:{type:"text",val:"#fff"}
};
var DrawPic=function(){
    let a=userField.size.val;
    let w=mycanvas.width;
    let h=mycanvas.height;
    ctx.fillStyle=userField.color.val;

    //h*=Math.abs(Math.sin(new Date().getTime()/1000));
    h*=1;
    for(let i=0; i<w;i+=a){
        for(let j=0; j<h;j+=a){
            ctx.fillRect(i,j,a/2,a/2);
        }
    }
}`,};
        <?php
            if($codeid){
                echo 'mysqlData={';
                echo '"codeid":"'.$codeData["codeid"].'",';
                echo '"codename":"'.$codeData["codename"].'",';
                echo '"picid":"'.$codeData["picid"].'",';
                echo '"picpath":"'.$codeData["picpath"].'",';
                echo '"codecontent":`'.$codeData["codecontent"].'`,';
                echo '}';
            }
        ?>
    </script>
<?php
    require $ConfPath["top"];
?>
    <!-- ==================显示部分 -->
    <div>
        <img id="pic" alt=""/>
        <canvas id="mycanvas"></canvas>
        <input id="loop" type="checkbox" />
    </div>

    <!-- ===================编辑部分 -->
    <div>
        <form action="/code/uploadcode" method="post" onkeydown="if(event.keyCode==13){return ;}">
            <input id="codeid" type="hidden" name="codeid">
            <label for="codename">特效名</label><input id="codename" name="codename" type="text" onkeydown="if(event.keyCode==13){return false;}">
            <label for="codename">图片ID</label><input id="picid" type="text" name="picid" onkeydown="if(event.keyCode==13){return false;}"/>
            <div id="argumentsBox">
                
            </div>
            <textarea id="codeText" name="codecontent"></textarea>

            <span></span> 
            <?php
                if($codeid){
                    echo '<input type="submit" name="type" value="修改">';
                }else{
                    echo '<input type="submit" name="type" value="添加">';
                }
            ?>
        </form>
    </div>

    <script src="/file/edit/edit.js"></script>
</body>
</html>