<?php
  $db_name        = "mybiyesheji";
  $mysql_username = "root";
  $mysql_password = "123456";         //服务器端"mysqlroot"
  $server_name    = "localhost";
  $conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name);
  if($conn){
    // echo "connection success";
  }else{
    echo "connection failed";
    die;
  }

  function getNumRows($mysql_qry){
    $result = mysqli_query($GLOBALS['conn'],$mysql_qry);
    // var_dump($result);
    return mysqli_num_rows($result);
  }


  // $mysql_qry="select * from $table where username = '$username' and password = '$password';";



  function get1Result($tableName,$where){ //$conditions结构 ["id"=>110,"name"=>"Tom"]
    $mysql_qry="select * from $tableName";
    if(isset($where)){
      $mysql_qry.=" where";
      $isFirst=true;
      foreach($where as $i => $val){
        if($isFirst){
          $mysql_qry.=" {$i} = '{$val}'";
          $isFirst=false;
        }else{
          $mysql_qry.=" and {$i} = '{$val}'";
        }
        // echo " $i , $val ";
      }
    }
    $result = mysqli_query($GLOBALS['conn'],$mysql_qry);
    $row = mysqli_fetch_assoc($result);
    echo $mysql_qry;
    var_dump($row);
    return $row;
  }

  function modif1Row($tableName,$data,$where){
    $mysql_qry="UPDATE $tableName SET ";
    $isFirst=true;
    foreach($data as $i => $val){
      if($isFirst){
        $mysql_qry.=" {$i} = '{$val}'";
        var_dump("  {$i} = '{$val}'");
        $isFirst=false;
      }else{
        $mysql_qry.=" , {$i} = '{$val}'";
      }
      // echo " $i , $val ";
    }

    $isFirst=true;
    if(isset($where)){
      $mysql_qry.=" where";
      foreach($where as $i => $val){
        if($isFirst){
          $mysql_qry.=" {$i} = '{$val}'";
          $isFirst=false;
        }else{
          $mysql_qry.=" and {$i} = '{$val}'";
        }
        // echo " $i , $val ";
      }
    }

    echo $mysql_qry;
    $result = mysqli_query($GLOBALS['conn'],$mysql_qry);
    var_dump($result);
  }
?>