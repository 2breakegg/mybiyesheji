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
    }
    .top_2{
        width:960px;
        margin:0 auto;
    }
    .top_2left{
        float:left;
    }
    .top_2right{
        float:right;
    }
</style>

<div class="top">
    <div class="top_2">
        <div class="top_2left">
            <a href="/">首页</a>
        </div>
        <div class="top_2right">
        <?php 
            if(isset($_COOKIE['userid']) && isset($_COOKIE['username'])){
                // echo "'{$_COOKIE['userid']}'";
                echo "<a href='/user/info?userid={$_COOKIE['userid']}'>{$_COOKIE['username']}</a>";
            }else{
                echo '<a href="/user/login">登录</a>';
            }
        ?>
        </div>
        <div style="clear:both"></div>
    </div>
</div>