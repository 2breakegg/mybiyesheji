<!-- //search -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/file/css/main.css">
    <title>搜索</title>
    <style>
        .headline2{
            font-size:20px;
            background:#ccc;
            padding:5px;
        }

        .picBigBox, .codeBigBox, .userBigBox{
            min-height:100px;
        }
        #searchBar{
            /* float: right; */
            position: relative;
            text-align: center;
            margin:10px;
        }
    </style>
</head>
<body>
    <?php
        require_once $ConfPath["top"];
        require_once $ConfPath["mymodel"];
        require_once $ConfPath["showcode"];
        require_once $ConfPath["showpic"];
        require_once $ConfPath["showuser"];

        // $MyConf["can_log"]=true;
        // $MyConf["can_logM"]=true;
        $keyword=$_GET["keyword"];
        Class Search{
            static function init(){
                $keyword=$_GET["keyword"];
            }

            static function showPics($keyword){
                $picsdata=MyModel::getInstance()->getPicsByPicnamePart($keyword);
                if($picsdata){
                    ShowPic::showPics($picsdata);
                }else{
                    echo "搜索不到有关内容";
                }
                logvar($picsdata);
            }
            static function showCodes($keyword){
                $codesdata=MyModel::getInstance()->getCodesByCodenamePart($keyword);
                if($codesdata){
                    ShowCode::showCodes($codesdata);
                }else{
                    echo "搜索不到有关内容";
                }
                logvar($codesdata);
            }
            static function showUsers($keyword){
                $usersdata=MyModel::getInstance()->getUsersByNicknamePart($keyword);
                if($usersdata){
                    ShowUser::showUsers($usersdata);
                }else{
                    echo "搜索不到有关内容";
                }
                logvar($usersdata);
            }
        }


        // Search::showPics($keyword);
        // Search::showCodes($keyword);
        // Search::showUsers($keyword);
    ?>
    <div class="mainBox">
        <div id="searchBar">
            <form action="/search/" method="GET">
                <input type="text" name="keyword"/>
                <input type="submit" value="搜索" />
            </form>
        </div>
        <div class="picBigBox">
            <div class="headline2">图片</div>
            <?php
                Search::showPics($keyword);
            ?>
        </div>
        <div class="codeBigBox">
            <div class="headline2">特效</div>
            <?php
                Search::showCodes($keyword);
            ?>
        </div>
        <div class="userBigBox">
            <div class="headline2">用户</div>
            <?php
                Search::showUsers($keyword);
            ?>
        </div>
    </div>
</body>
</html>