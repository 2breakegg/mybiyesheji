<?php 
    @define("WWWROOT",str_replace("/index.php" , "", str_replace("\\","/",__FILE__))."/");
    @define("APPROOT",WWWROOT."app");
    require_once WWWROOT."conf.php";
    require_once WWWROOT."forlog.php";

    $Paths = array("now"=>-1); // now 当前已访问到了路径 下标
    
    function WWWGetRequirePath($ConfPath){
        $logAble=true;
        if($logAble){
            echo "<h1>//====index.php log=====</h1>";
            echo "PHP_SELF:　　".$_SERVER['PHP_SELF']."<br/>";
            echo "__FILE__:　　".__FILE__."<br/>";
            echo "WWWROOT: 　　".WWWROOT."<br/>";
            echo "APPROOT: 　　".APPROOT."<br/>";
        }
        // require APPROOT."index.php";
        $path_str=str_replace("//" , "/",$_SERVER['PHP_SELF']);
        $path_str=str_replace("/index.php/" , "",$_SERVER['PHP_SELF']);
        $path_str=str_replace("/index.php" , "",$path_str);
        $paths = explode("/",$path_str);
        $paths["now"]=0;
        @$requirePath = $ConfPath[$paths[$paths["now"]]] ? $ConfPath[$paths[$paths["now"]]] : $ConfPath["404"];
        if($logAble){
            echo "<br/>path_str:　　".$path_str."<br/>";
            echo "path1: 　　";
            echo "<pre>";
            var_dump($paths);
            echo "</pre>";
            echo "requirePath:　　"."<br/>".$requirePath."<br/>";
            echo "<h2>//====index.php log END=====</h2>";
        }
        $GLOBALS["Paths"]=$paths;
        return $requirePath;
    }

    require_once WWWGetRequirePath($ConfPath);
?>

