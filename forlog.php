<?php
// ===================一般 用
    function loge2($obj2,$name="no name ",$force=false){
        if(!$force){
            if(!$GLOBALS['MyConf']['can_log']) return;
        }
        loge2__($obj2,$name);
    }

    function logvar($obj2,$name="no name ",$force=false){
        if(!$force){
            if(!$GLOBALS['MyConf']['can_log']) return;
        }
        logvar__($obj2,$name);
    }
    function logr($obj2,$name="no name ",$force=false){
        if(!$force){
            if(!$GLOBALS['MyConf']['can_log']) return;
        }
        logr__($obj2,$name);
    }

// ===================model 用
    function loge2M($obj2,$name="no name "){
        if(!$GLOBALS['MyConf']['can_logM']) return;
        loge2__($obj2,$name);
    }

    function logvarM($obj2,$name="no name "){
        if(!$GLOBALS['MyConf']['can_logM']) return;
        logvar__($obj2,$name);
    }
    function logrM($obj2,$name="no name "){
        if(!$GLOBALS['MyConf']['can_logM']) return;
        logr__($obj2,$name);
    }
//===========本体
    function loge2__($obj2,$name){
        echo "<br>";
        echo $name." : ".$obj2;
        echo "<br>";
    }
    function logvar__($obj2,$name){
        echo "<pre>";
        echo $name." : ";
        var_dump($obj2);
        echo "</pre>";
    }
    function logr__($obj2,$name){
        echo "<pre>";
        echo $name." : ";
        print_r($obj2);
        echo "</pre>";
    }
?>