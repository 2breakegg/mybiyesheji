<?php

    function codeRoute(){ //单纯的找到应该require的路径 并返回str
        $GLOBALS["Paths"]["now"]++;
        $Paths=$GLOBALS["Paths"];
        $thisRoot=APPROOT."/code";
        $codeRoute=array(
            "uploadcode"=>$thisRoot."/uploadcode.php",
        );

        @$requirePath = $codeRoute[$Paths[$Paths["now"]]] 
            ? $codeRoute[$Paths[$Paths["now"]]] : $thisRoot."/code.php";
        return $requirePath;
    }
    
    require_once codeRoute();
?>