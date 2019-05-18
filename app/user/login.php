<?php
    require APPROOT."/model/conn.php";
    function signIn(){
        //获取用户名密码,判断是否为空
        $username=$_POST["username"];
        $password=$_POST["password"];
        $table="user";
        $message=array();

        if($username==false || $password==false || $username=='' || $password==''){
            $message['text']='用户名或密码不能为空';
            echo $message['text'];
            return;
        }
        
        $password=$GLOBALS['MyConf']['md5'] ? md5($password) : $password;
        $mysql_qry="select * from $table where username = '$username' and password = '$password';";
        //执行语句账号密码匹配
        $result = mysqli_query($GLOBALS['conn'],$mysql_qry);
        $b=mysqli_num_rows($result);

        if($b>1){
            //多个账号密码匹配
            $message['text']='数据库出错,请告诉我(开发者)';
        }else if($b==1){
            //登录成功
            $row = mysqli_fetch_assoc($result);
            $message['text']='登录成功';
            setcookie('userid',$row['userid'],time()+60*60*24*365,'/');
            setcookie('username',$row['username'],time()+60*60*24*365,'/');
            header("Location: /index.php"); 
        }else{
        //账户或密码错误
            $message['text']='账号或密码错误';
        }
        echo $message['text'];
    }
    function signUp(){
        //获取用户名密码,判断是否为空
        $username=$_POST["username"];
        $password=$_POST["password"];
        $table="user";
        $message=array();

        if($username==false || $password==false || $username=='' || $password==''){
            $message['text']='用户名或密码不能为空';
            echo $message['text'];
        }

        //查看用户名是否被注册   
        $mysql_qry="select * from $table where username = '$username'";
        $result = mysqli_query($GLOBALS['conn'],$mysql_qry);
        $b=mysqli_num_rows($result);
        if($b>0){
            $message['text']='该用户名已被注册';
            echo $message['text'];
            return;
        }

        $password=$GLOBALS['MyConf']['md5'] ? md5($password) : $password;
        $nowTime=time();
        $mysql_qry="insert into $table (username,password,signuptime) values('$username','$password',{$nowTime})";
        $result = mysqli_query($GLOBALS['conn'],$mysql_qry);
        
        if($result){
            //注册成功 返回 id username...
            $mysql_qry="select * from $table where username = '$username';";
            $result = mysqli_query($GLOBALS['conn'],$mysql_qry);
            $b=mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            
            $message['text']='注册成功';
            
        }else{
            $message['text']='注册失败,数据库错误';
        }
        echo $message['text'];
    }
    function signOut(){
        setcookie('userid',$row['userid'],time()-1,'/');
        header("Location: /index.php");
    }
    //主入口
    function init(){
        // if(isset($_COOKIE['username'])){
        //     echo "run header";
        //     header("Location: /index.php"); 
        // }
        @$GLOBALS['type']=$_POST["type"];
        echo $type=$GLOBALS['type'];
        if($type==""){
            echo "showSignIn()";
        }elseif($type=="signIn"){
            signIn();
        }elseif($type=="signUp"){
            signUp();
        }elseif($type=="signOut"){
            signOut();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/file/css/main.css" type="text/css">
    <title>登录</title>
    <style>
        .tabBox{
            margin: auto;
            width:300px;
            padding: 0;
        }
        .tab{
            margin: 0;
            padding: 10px 5px;
            text-align: center;
            width: 140px;
            float: left;
        }

        .tab:hover{
            background:rgb(134, 148, 224);
        }

        .selected{
            color:#fff;
            background:rgb(62, 88, 231);
        }
    </style>
</head>
<body>
    <div style="border:1 black soild">
        php 输出: <br/>
        <?php init();?>
    </div>

    <div>

        <!-- =============================登录 -->
        <div class="tabBox">
            <div id="signInTab" class="tab" onclick="showSignIn()">登录</div>
            <div id="signUpTab" class="tab" onclick="showSignUp()">注册</div>
            <div style="clear: both"></div>
        </div>
        <form id="signIn"  method="POST" style="text-align: center">
            <input type="hidden" name="type" value="signIn">
            <label for="username" >用户名</label>
            <input id="username" name="username" type="text"/>
            <br><br>
            <label for="password">密码</label>
            <input id="password" name="password" type="password"/>
            <br><br>
            <input type="submit" value="登录">
        </form>

        <!-- =============================注册 -->
        <form id="signUp" method="POST" style="text-align: center">
            <input type="hidden" name="type" value="signUp">
            <label for="username2" >用户名*</label>
            <input id="username2" name="username" type="text"/>
            <br><br>
            <label for="password2">密码*</label>
            <input id="password2" name="password" type="password"/>
            <br><br>
            <input type="submit" value="注册">
        </form>
    </div>

    <script>
        function showSignIn(){
            let ele1=document.getElementById("signIn");
            let ele2=document.getElementById("signUp");
            ele1.style.display="block";
            ele2.style.display="none";

            let tabIn=document.getElementById("signInTab");
            let tabUp=document.getElementById("signUpTab");
            tabIn.classList.add("selected")
            tabUp.classList.remove("selected")
        }

        function showSignUp(){
            let ele1=document.getElementById("signUp");
            let ele2=document.getElementById("signIn");
            ele1.style.display="block";
            ele2.style.display="none";

            let tabIn=document.getElementById("signInTab");
            let tabUp=document.getElementById("signUpTab");
            tabUp.classList.add("selected")
            tabIn.classList.remove("selected")
        }
        window.onload=function(){
            let type=<?php echo "\"$type\""?>;
            if(type=="signup"){
                showSignup();
            }else{
                showSignIn();
            }
        }
        
    </script>
</body>
</html>