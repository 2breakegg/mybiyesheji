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
                    // loge2M("connection success");
                }else{
                    loge2M("connection failed");
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
                    // loge2(" $i , $val ");
                }
            }
            $result = mysqli_query($this->conn,$mysql_qry);
            $row = mysqli_fetch_assoc($result);
            $mysql_qry;
            logvarM($row);
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
                logvarM("  {$i} = '{$val}'");
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

            loge2M($mysql_qry);
            $result = mysqli_query($this->conn,$mysql_qry);
            logvarM($result);
        }

//=================pic表操作
        function addPic($picname,$picpath,$userid,$uploadtime){
            $this->connectMyDB();

            $tableName="pic";
            $mysql_str="INSERT INTO pic ( picname, picpath, userid, uploadtime)
                       VALUES ( '{$picname}','{$picpath}',{$userid},{$uploadtime});";
            
            loge2M($mysql_str);
            $result = mysqli_query($this->conn,$mysql_str);

        }

        function getPicByPicid($picid){
            $this->connectMyDB();

            $mysql_str="SELECT * FROM pic WHERE picid = '{$picid}'";

            $result = mysqli_query($this->conn,$mysql_str);
            $Data=Array();

            while($row = mysqli_fetch_assoc($result)){
                $Data[count($Data)]=$row;
            }
            // logvarM($Data);
            return $Data;
        }
        function getPicByUserid($userid){
            $this->connectMyDB();

            $mysql_str="SELECT * FROM pic WHERE userid = '{$userid}'";

            $result = mysqli_query($this->conn,$mysql_str);
            $picData=Array();

            while($row = mysqli_fetch_assoc($result)){
                $picData[count($picData)]=$row;
            }
            // logvarM($picData);
            return $picData;
        }

//================code表操作
        function getCodeByUserid($userid){
            $this->connectMyDB();

            $mysql_str="SELECT * FROM code WHERE userid = '{$userid}'";

            $result = mysqli_query($this->conn,$mysql_str);
            $Data=Array();

            while($row = mysqli_fetch_assoc($result)){
                $Data[count($Data)]=$row;
            }
            // logvarM($Data,"");
            return $Data;
        }


        function addCode($codename,$codecontent,$userid,$uploadtime,$picid){
            $this->connectMyDB();

            $tableName="pic";
            $mysql_str="INSERT INTO pic ( codename, codecontent, userid, uploadtime, picid)
                       VALUES ( '{$codename}','{$codecontent}',{$userid},{$uploadtime},{$picid});";
            
            // loge2M($mysql_str);
            $result = mysqli_query($this->conn,$mysql_str);

        }

        function getCodeById($codeid){
            $this->connectMyDB();

            $mysql_str="SELECT * FROM code WHERE codeid = '{$codeid}'";
            loge2M($mysql_str);
            $result = mysqli_query($this->conn,$mysql_str);
            $Data=Array();

            while($row = mysqli_fetch_assoc($result)){
                $Data[count($Data)]=$row;
            }
            $picpath=$this->getPicByPicid($Data[0]["picid"])[0]["picpath"];
            $Data[0]["picpath"]=$picpath;
            logvarM($Data,"getCodeById");
            return $Data;
        }
//==========================test
        function test(){

        }
    }
?>