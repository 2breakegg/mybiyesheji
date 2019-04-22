<?php

    function userRoute(){ //单纯的找到应该require的路径 并返回str
        $Paths=$GLOBALS["Paths"];
        $thisRoot=APPROOT."/user";
        $userRoute=array(
            // "user"=>APPROOT."/user"
            "login"=>$thisRoot."/login.php",
            "login.php"=>$thisRoot."/login.php",
            ""=>$thisRoot."/userindex.php",
            "info"=>$thisRoot."/userindex.php",
        );
        ++$Paths["now"];
        @$requirePath = $userRoute[$Paths[$Paths["now"]]] 
            ? $userRoute[$Paths[$Paths["now"]]] : $ConfPath["404"];
        return $requirePath;
    }
    
    require_once userRoute();
?>