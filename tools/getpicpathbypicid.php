<?php
@define("WWWROOT",str_replace("/tools/getpicpathbypicid.php" , "", str_replace("\\","/",__FILE__))."/");
@define("APPROOT",WWWROOT."app");
require_once WWWROOT."conf.php";
require_once WWWROOT."forlog.php";

$picid=$_POST["picid"];
require_once $ConfPath["mymodel"];

echo MyModel::getInstance()->getPicPathByPicid($picid);
?>