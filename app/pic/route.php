<?php

    function picRoute(){ //单纯的找到应该require的路径 并返回str
        $GLOBALS["Paths"]["now"]++;
        $Paths=$GLOBALS["Paths"];
        $thisRoot=APPROOT."/pic";
        $codeRoute=array(
            "uploadpic"=>$thisRoot."/uploadpic.php",
            "uploadpic.php"=>$thisRoot."/uploadpic.php",
            "collectpic"=>$thisRoot."/collectpic.php",
            "collectpic.php"=>$thisRoot."/collectpic.php",
        );

        @$requirePath = $codeRoute[$Paths[$Paths["now"]]] 
            ? $codeRoute[$Paths[$Paths["now"]]] : $thisRoot."/pic.php";
        return $requirePath;
    }
    
    require_once picRoute();
?>