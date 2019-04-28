// info 个人信息显示页
<?php
    require_once $ConfPath["mymodel"];;

    $tableName="user";
    @$userid=$_GET["userid"];
    @$userid_cookie=$_COOKIE["userid"];
    $isSelf=$userid==$userid_cookie;

    //=======================修改数据
    function modif(){
        if($GLOBALS['isSelf'] && isset($_POST['ispost'])){
            $tableName="user";
            $where=["userid"=>$GLOBALS['userid']];
            $data=[
                "nickname"=>$_POST["nickname"],
                "email"=>$_POST["email"],
                "phone"=>$_POST["phone"]
            ];
            MyModel::getInstance()->modif1Row($tableName,$data,$where);
        }else{
            loge2("no ispost");
        }
    }
    modif();
    //=======================查找数据
    $conditions=["userid"=>$userid];
    $row=MyModel::getInstance()->get1Result($tableName,$conditions);
?>
<style>
    .infoTable{
        border:1px black solid;
    }
    .infoTable tr td:nth-child(1){
        text-align: right;
    }
</style>
<div>
    <table id="infoTable" class="infoTable">
        <tr><td>ID</td>         <td><?php echo $row['userid'] ?></td></tr>
        <tr><td>用户名</td>     <td><?php echo $row['username'] ?></td></tr>
        <tr><td>昵称</td>       <td><?php echo $row['nickname'] ?></td></tr>
        <tr><td>email</td>      <td><?php echo $row['email'] ?></td></tr>
        <tr><td>phone</td>      <td><?php echo $row['phone'] ?></td></tr>
        <tr><td>注册时间</td>    <td><?php echo date('Y-m-d',$row['signuptime']) ?></td></tr>
        <?php if($isSelf) echo "<tr><td colspan='2' style='text-align:center'><button type='button' onclick='showModiTable()'>修改信息</button></td></tr>" ?>
    </table>

    <table id="modiTable" class="infoTable">
        <form method="POST">
            <input type="hidden" name="ispost" value="true"/>
            <tr><td>ID</td>         <td><?php echo $row['userid'] ?></td></tr>
            <tr><td>用户名</td>     <td><?php echo $row['username'] ?></td></tr>
            <tr><td>昵称</td>       <td><input name="nickname" type="text" value="<?php echo $row['nickname'] ?>"> </td></tr>
            <tr><td>email</td>      <td><input name="email" type="text" value="<?php echo $row['email'] ?>"></td></tr>
            <tr><td>phone</td>      <td><input name="phone" type="text" value="<?php echo $row['phone'] ?>"></td></tr>
            <tr><td>注册时间</td>    <td><?php echo date('Y-m-d',$row['signuptime']) ?></td></tr>
            <tr><td colspan="2" style="text-align:center"><input type="submit"/> <button type="button" onclick='showInfoTable()'>取消</button></td></tr>
        </form>
    </table>

    <script>
        function showModiTable(){
            var el_modiTable=document.getElementById("modiTable");
            var el_infoTable=document.getElementById("infoTable");
            el_modiTable.style.display="";
            el_infoTable.style.display="none";
        }
        function showInfoTable(){
            var el_modiTable=document.getElementById("modiTable");
            var el_infoTable=document.getElementById("infoTable");
            el_modiTable.style.display="none";
            el_infoTable.style.display="";
        }

        showInfoTable();
    </script>
</div>