<?php 
//============  file   route   =====================
    function userRoute(){ //单纯的找到应该require的路径 并返回str
        $Paths=$GLOBALS["Paths"];
        $thisRoot=APPROOT."/file";
        $userRoute=array(
            "css"=>$thisRoot."/css/",
            "js"=>$thisRoot."/js/",
            "pic"=>$thisRoot."/pic/",
        );
        $Paths["now"]++;
        @$requirePath = $userRoute[$Paths[$Paths["now"]]] 
            ? $userRoute[$Paths[$Paths["now"]]] : $ConfPath["404"];

        $Paths["now"]++;
        $requirePath .= $Paths[$Paths["now"]];

        // loge2($requirePath,"");
        return $requirePath;
    }
    


    readfile(userRoute()); 
    // readfile("d:/css/a.css")
?>