<style>
    body,div{
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
        line-height:30px;
    }
    .top_2right{
        float:right;
        width:100px;
        padding: 4px;
    }

    .downList{
        display: none;
        margin: 0;
        background: #ddd;
        width:70px;
    }
    a:hover .downList{
        display: block;
    }
    .downList input{
        background:#ddd;
        border: 0;
        width:100%;
        font-size: 15px;
    }
    .downList input:hover{
        display: block;
        background: #ccc;
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
                    require_once $ConfPath["mymodel"];
                    ?>
                    <a href='/user/info?userid=<?php echo $_COOKIE['userid'] ?>'><?php echo MyModel::getInstance()->getNicknameByUserid($_COOKIE['userid'])?>
                        <div class="downList">
                            <form action="/user/login" method="POST">
                                <input type="hidden" name="type" value="signOut">
                                <input type="submit" value="注销">
                            </form>
                        </div>
                    </a>
                    <?php
                }else{
                    echo '<a href="/user/login">登录</a>';
                }
            ?>
        </div>
        <div style="clear:both"></div>
    </div>
</div>