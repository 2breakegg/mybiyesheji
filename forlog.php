<?php
    function loge2($obj2,$name="no name "){
        if(!$GLOBALS['MyConf']['can_log']) return;
        echo "<br>";
        echo $name." : ".$obj2;
        echo "<br>";
    }

    function logvar($obj2,$name="no name "){
        if(!$GLOBALS['MyConf']['can_log']) return;
        echo "<pre>";
        echo $name." : ";
        var_dump($obj2);
        echo "<pre>";
    }
    function logr($obj2,$name="no name "){
        if(!$GLOBALS['MyConf']['can_log']) return;
        echo "<pre>";
        echo $name." : ";
        print_r($obj2);
        echo "<pre>";
    }
?>