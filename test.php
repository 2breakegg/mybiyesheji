<?php
    function fun1(){
        echo "fun1";
    }

    // $fun22=function fun2(){
    //     echo "fun2";
    // };

    function f($fun){
        $fun;
    }

    function init(){
        $fun=fun2;
        f($fun);
    }

    init();
?>