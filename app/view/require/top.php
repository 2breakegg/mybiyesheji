<style>
    body div{
        margin:0;
        padding:0;
    }
    .top{
        min-width: 960px;
        height:30px;
        margin:0;
        padding:0 30px;
        background:#ccf;
        text-align: right;
    }
    .top_2{
        width:960px;
        margin:0 auto;
    }
</style>

<div class="top">
    <div class="top_2">
    <?php 
        if(isset($_COOKIE['username'])){
            // echo "'{$_COOKIE['userid']}'";
            echo "<a href='/user/info?userid={$_COOKIE['userid']}'>{$_COOKIE['username']}</a>";
        }else{
            echo '<a href="/user/login">登录</a>';
        }
    ?>
    </div>
</div>