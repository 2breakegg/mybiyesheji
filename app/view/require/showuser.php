<?php
    require_once $ConfPath["mymodel"];

    class ShowUser{
        static function init(){

        }

        static function showUsers($usersdata){
            echo "<table>";
            for($i=0;$i<count($usersdata);$i++){
                echo "<tr>";
                echo "<td><a href='/user/info?userid={$usersdata[$i]["userid"]}'>{$usersdata[$i]["nickname"]}</a></td>";
                echo "<td>粉丝数:".$usersdata[$i]["fansnum"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

?>