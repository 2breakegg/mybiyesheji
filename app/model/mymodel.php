<?php
    class MyModel{
//=================变量        
        var $db_name        = "mybiyesheji";
        var $mysql_username = "root";
        var $mysql_password = "123456";         //服务器端"mysqlroot"
        var $server_name    = "localhost";
        var $conn;
//=================单例
        private static $_instance = NULL;
        //单例 禁止外部直接实例化
        private function __construct() {
        }

        public static function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new MyModel();
            }

            return self::$_instance;
        }
        //单例 禁止克隆实例
        public function __clone(){
            die('Clone is not allowed.' . E_USER_ERROR);
        }
//=================数据库基础操作
        //连接数据库
        private function connectMyDB(){
            if($this->conn==null){
                $this->conn = mysqli_connect($this->server_name,$this->mysql_username,$this->mysql_password,$this->db_name);
                if($this->conn){
                    // echo "connection success";
                }else{
                    echo "connection failed";
                    die;
                }
            }
        }
        //获取消息条数
        function getNumRows($mysql_qry){
            $this->connectMyDB();
            $result = mysqli_query($this->conn,$mysql_qry);
            return mysqli_num_rows($result);
        }
        //获取一条消息
        function get1Result($tableName,$where){ //$conditions结构 ["id"=>110,"name"=>"Tom"]
            $this->connectMyDB();
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
            $result = mysqli_query($this->conn,$mysql_qry);
            $row = mysqli_fetch_assoc($result);
            echo $mysql_qry;
            var_dump($row);
            return $row;
        }
        //修改一条消息
        function modif1Row($tableName,$data,$where){
            $this->connectMyDB();
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
            $result = mysqli_query($this->conn,$mysql_qry);
            var_dump($result);
        }

//=================pic表操作
        function addPic($picname,$picpath,$userid,$uploadtime){
            $this->connectMyDB();

            $tableName="pic";
            $mysql_str="INSERT INTO pic ( picname, picpath, userid, uploadtime)
                       VALUES ( '{$picname}','{$picpath}',{$userid},{$uploadtime});";
            
            echo $mysql_str;
            $result = mysqli_query($this->conn,$mysql_str);

        }


        function getPicByUserid($userid){
            $this->connectMyDB();

            $tableName="pic";
            $mysql_str="SELECT * FROM pic WHERE userid = '{$userid}'";

            $result = mysqli_query($this->conn,$mysql_str);
            $picData=Array();

            while($row = mysqli_fetch_assoc($result)){
                $picData[count($picData)]=$row;
            }
            echo "<pre>";
            echo count($picData);

            print_r($picData);

            echo "</pre>";

            return $picData;
        }


//==========================test
        function test(){

        }
    }
?>