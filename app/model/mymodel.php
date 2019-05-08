<?php
    class MyModel{
//=================变量        
        static $conn;
//=================单例
        private static $_instance = NULL;
        //单例 禁止外部直接实例化
        private function __construct() {
        }

        public static function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new MyModel();
                self::connectMyDB();
            }

            return self::$_instance;
        }
        //单例 禁止克隆实例
        public function __clone(){
            die('Clone is not allowed.' . E_USER_ERROR);
        }
//=================数据库基础操作
        //连接数据库
        private static function connectMyDB(){
            $mysql=$GLOBALS["MyConf"]["mysql"];
            if(self::$conn==null){
                self::$conn = mysqli_connect($mysql["server_name"],$mysql["mysql_username"],$mysql["mysql_password"],$mysql["db_name"]);
                if(self::$conn){
                    // loge2M("connection success");
                }else{
                    loge2M("connection failed");
                    die;
                }
            }
        }
        //获取消息条数
        function getNumRows($mysql_qry){
            
            $result = mysqli_query(self::$conn,$mysql_qry);
            return mysqli_num_rows($result);
        }
        //获取一条消息
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
                    // loge2(" $i , $val ");
                }
            }
            $result = mysqli_query(self::$conn,$mysql_qry);
            $row = mysqli_fetch_assoc($result);
            $mysql_qry;
            logvarM($row);
            return $row;
        }
        //修改一条消息
        function modif1Row($tableName,$data,$where){
            
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
            $result = mysqli_query(self::$conn,$mysql_qry);
            logvarM($result);
        }

//=================pic表操作
        function addPic($picname,$picpath,$userid,$uploadtime){
            $tableName="pic";
            $mysql_str="INSERT INTO pic ( picname, picpath, userid, uploadtime)
                       VALUES ( '{$picname}','{$picpath}',{$userid},{$uploadtime});";
            
            loge2M($mysql_str);
            $result = mysqli_query(self::$conn,$mysql_str);

        }

        function getPicPathByPicid($picid){
            $Data=$this->getPicByPicid($picid);
            $result=$Data[0]["picpath"];
            return $result;
        }
        function getPicByPicid($picid){
            $mysql_str="SELECT * FROM pic WHERE picid = '{$picid}'";

            $result = mysqli_query(self::$conn,$mysql_str);
            $Data=Array();

            if(!mysqli_num_rows($result)){
                $mysql_str="SELECT * FROM pic WHERE picid = '0'";
                $result = mysqli_query(self::$conn,$mysql_str);
            }
            while($row = mysqli_fetch_assoc($result)){
                $Data[count($Data)]=$row;
            }
            // logvarM($Data);
            return $Data;
        }
        function getPicByUserid($userid){
            $mysql_str="SELECT * FROM pic WHERE userid = '{$userid}'";

            $result = mysqli_query(self::$conn,$mysql_str);
            $picData=Array();

            while($row = mysqli_fetch_assoc($result)){
                $picData[count($picData)]=$row;
            }
            // logvarM($picData);
            return $picData;
        }

//================code表操作
        function getCodeByUserid($userid){
            $mysql_str="SELECT * FROM code WHERE userid = '{$userid}'";

            $result = mysqli_query(self::$conn,$mysql_str);
            $Data=Array();

            while($row = mysqli_fetch_assoc($result)){
                $Data[count($Data)]=$row;
            }
            // logvarM($Data,"");
            return $Data;
        }

        function modifyCode($codeid,$codename,$codecontent,$userid,$picid){//自行判断修改者是不是原作者,不是则不修改
            $codecontent=mysqli_real_escape_string(self::$conn,$codecontent);
            $uploadtime=time();
            $mysql_str="UPDATE code SET codename='{$codename}' , codecontent='{$codecontent}' , uploadtime='{$uploadtime}' , picid={$picid} WHERE codeid={$codeid}";
            $isSameUser = MyModel::getInstance()->get1Result("code",["codeid"=>$codeid,"userid"=>$userid]);
            // logvarM()
            if($isSameUser){
                loge2M("用户id一致,执行修改");
                loge2M($mysql_str);
                return mysqli_query(self::$conn,$mysql_str);
            }else{
                loge2M("用户id不一致,不修改");
                return false;
            }
        }

        function addCode($codename,$codecontent,$userid,$picid){
            $uploadtime=time();
            $mysql_str="INSERT INTO code ( codename, codecontent, userid, uploadtime, picid)
                       VALUES ( '{$codename}','{$codecontent}',{$userid},{$uploadtime},{$picid});";
            
            // loge2M($mysql_str);
            return mysqli_query(self::$conn,$mysql_str);
        }

        function getCodeById($codeid){
            $mysql_str="SELECT * FROM code WHERE codeid = '{$codeid}'";
            loge2M($mysql_str);
            $result = mysqli_query(self::$conn,$mysql_str);
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