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
        function getRowsByMysql_str($mysql_str){
            $data=mysqli_query(self::$conn,$mysql_str);
            $result=Array();
            while($row = mysqli_fetch_assoc($data)){
                $result[count($result)]=$row;
            }
            return $result;
        }
// ============================user表
        function getNicknameByUserid($userid){
            $mysql_str="SELECT nickname FROM user WHERE userid = '{$userid}'";
            $result = mysqli_query(self::$conn,$mysql_str);
            return mysqli_fetch_assoc($result)["nickname"];
        }
        function getUserByUserid($userid){
            $mysql_str="SELECT * FROM user WHERE userid = '{$userid}'";
            $result = mysqli_query(self::$conn,$mysql_str);
            return mysqli_fetch_assoc($result);
        }
        function getUsersByUserids($upids){

            logvar($upids,"upids");
            if(!$upids){
                return Array();
            }
            $mysql_str="SELECT * FROM user WHERE ";
            for($i=0; $i<count($upids)-1; $i++){
                $mysql_str.=" userid={$upids[$i]} OR ";
            }
            $mysql_str.=" userid={$upids[$i]}";
            $mysql_data=mysqli_query(self::$conn,$mysql_str);
            $result=array();
            while($row = mysqli_fetch_assoc($mysql_data)){
                $result[count($result)]=$row;
            }
            return $result;
        }
        function getUsersByNicknamePart($keyword){
            $mysql_str="SELECT * FROM user WHERE nickname LIKE '%{$keyword}%'";
            $mysql_data = mysqli_query(self::$conn,$mysql_str);
            $result=array();
            while($row = mysqli_fetch_assoc($mysql_data)){
                $result[count($result)]=$row;
            }
            return $result;
        }
        function getUsersAny(){
            // test
            $mysql_str="SELECT * FROM user";
            $mysql_data = mysqli_query(self::$conn,$mysql_str);
            $result=array();
            while($row = mysqli_fetch_assoc($mysql_data)){
                $result[count($result)]=$row;
            }
            return $result;
        }

        function fansAdd1($userid){
            $mysql_str="UPDATE user SET fansnum = fansnum+1 WHERE userid={$userid}";
            $userData=$this->getUserByUserid($userid);
            if($userData==false){
                return false;
            }
            return mysqli_query(self::$conn,$mysql_str);
        }
        function fansMinus1($userid){
            $mysql_str="UPDATE user SET fansnum = fansnum-1 WHERE userid={$userid}";
            $userData=$this->getUserByUserid($userid);
            if($userData==false){
                return false;
            }
            return mysqli_query(self::$conn,$mysql_str);
        }
//=================pic表操作
        function getPicPathByPicid($picid){
            $Data=$this->getPicByPicid($picid);
            $result=$Data[0]["picpath"];
            return $result;
        }
        function getPicByPicid($picid){
            $result = $this->getPicByPicid_($picid);
            $Data=Array();

            if(!mysqli_num_rows($result)){
                $picid = '0';
                $result = $this->getPicByPicid_($picid);
            }
            while($row = mysqli_fetch_assoc($result)){
                $Data[count($Data)]=$row;
            }
            // logvarM($Data);
            return $Data;
        }
        function getPicByPicid_($picid){
            $mysql_str="SELECT * FROM pic WHERE picid = '{$picid}'";
            $result = mysqli_query(self::$conn,$mysql_str);
            return $result;
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
        function getPicsByPicids($picids){
            if(!$picids){
                return Array();
            }
            $mysql_str="SELECT * FROM pic WHERE ";
            for($i=0; $i<count($picids)-1; $i++){
                $mysql_str.=" picid={$picids[$i]} OR ";
            }
            $mysql_str.=" picid={$picids[$i]}";
            $mysql_data=mysqli_query(self::$conn,$mysql_str);
            $result=array();
            while($row = mysqli_fetch_assoc($mysql_data)){
                $result[count($result)]=$row;
            }
            return $result;
            // $mysql_str+="picid={$picids[$i]}";
        }
        function getPicsByPicnamePart($keyword){
            $mysql_str="SELECT * FROM pic WHERE picname LIKE '%{$keyword}%'";
            $mysql_data = mysqli_query(self::$conn,$mysql_str);
            $result=array();
            while($row = mysqli_fetch_assoc($mysql_data)){
                $result[count($result)]=$row;
            }
            return $result;
        }
        function getPicsAny(){
            // test
            $mysql_str="SELECT * FROM pic WHERE picid!=0";
            $mysql_data = mysqli_query(self::$conn,$mysql_str);
            $result=array();
            while($row = mysqli_fetch_assoc($mysql_data)){
                $result[count($result)]=$row;
            }
            return $result;
        }

        function addPic($picname,$picpath,$userid){
            $uploadtime=time();
            $tableName="pic";
            $mysql_str="INSERT INTO pic ( picname, picpath, userid, uploadtime)
                       VALUES ( '{$picname}','{$picpath}',{$userid},{$uploadtime});";
            
            loge2M($mysql_str);
            $result = mysqli_query(self::$conn,$mysql_str);
            return $result;
        }
        function modifyPic($picid,$picname,$userid){//自行判断修改者是不是原作者,不是则不修改
            $uploadtime=time();
            $mysql_str="UPDATE pic SET picname='{$picname}' ,uploadtime='{$uploadtime}'  WHERE picid={$picid}";
            $isSameUser = MyModel::getInstance()->get1Result("pic",["picid"=>$picid,"userid"=>$userid]);
            logvarM($isSameUser,"isSameUser");
            if($isSameUser){
                loge2M("用户id一致,执行修改");
                loge2M($mysql_str);
                return mysqli_query(self::$conn,$mysql_str);
            }else{
                loge2M("用户id不一致,不修改");
                return false;
            }
        }
        function deletePic($picid,$userid){
            $mysql_str="DELETE FROM pic WHERE picid=$picid";
            $isSameUser = MyModel::getInstance()->get1Result("pic",["picid"=>$picid,"userid"=>$userid]);
            logvarM($isSameUser,"isSameUser");
            if($isSameUser){
                loge2M("用户id一致,执行修改");
                loge2M($mysql_str);
                return mysqli_query(self::$conn,$mysql_str);
            }else{
                loge2M("用户id不一致,不修改");
                return false;
            }
        }
        function collectPicAdd1($picid){//图片收藏量+1 操作失败 return false
            $mysql_str="UPDATE pic SET collectnum = collectnum+1 WHERE picid={$picid}";
            $picData=$this->getPicByPicid_($picid);
            if($picData==false){
                return false;
            }
            return mysqli_query(self::$conn,$mysql_str);
        }
        function collectPicMinus1($picid){//图片收藏量-1 操作失败 return false
            $mysql_str="UPDATE pic SET collectnum = collectnum-1 WHERE picid={$picid}";
            $picData=$this->getPicByPicid_($picid);
            if($picData==false){
                return false;
            }
            return mysqli_query(self::$conn,$mysql_str);
        }
//========================code表操作
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
        function getCodeByCodeid_($codeid){
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
        function getCodesByCodeids($codeids){
            if(!$codeids){
                return Array();
            }
            $mysql_str="SELECT * FROM code WHERE ";
            for($i=0; $i<count($codeids)-1; $i++){
                $mysql_str.=" codeid={$codeids[$i]} OR ";
            }
            $mysql_str.=" codeid={$codeids[$i]}";
            $mysql_data=mysqli_query(self::$conn,$mysql_str);
            $result=array();
            while($row = mysqli_fetch_assoc($mysql_data)){
                $result[count($result)]=$row;
            }
            return $result;
            // $mysql_str+="codeid={$codeids[$i]}";
        }
        function getCodesByCodenamePart($keyword){
            $mysql_str="SELECT * FROM code WHERE codename LIKE '%{$keyword}%'";
            $mysql_data = mysqli_query(self::$conn,$mysql_str);
            $result=array();
            while($row = mysqli_fetch_assoc($mysql_data)){
                $result[count($result)]=$row;
            }
            return $result;
        }
        function getCodesAny(){
            // test
            $mysql_str="SELECT * FROM code WHERE codeid!=0 ";
            $mysql_data = mysqli_query(self::$conn,$mysql_str);
            $result=array();
            while($row = mysqli_fetch_assoc($mysql_data)){
                $result[count($result)]=$row;
            }
            return $result;
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
        function deleteCode($codeid,$userid){
            $mysql_str="DELETE FROM code WHERE codeid=$codeid";
            $isSameUser = MyModel::getInstance()->get1Result("code",["codeid"=>$codeid,"userid"=>$userid]);
            if($isSameUser){
                loge2M("用户id一致,执行修改");
                loge2M($mysql_str);
                return mysqli_query(self::$conn,$mysql_str);
            }else{
                loge2M("用户id不一致,不修改");
                return false;
            }
        }

        function collectCodeAdd1($codeid){//图片收藏量+1 操作失败 return false
            $mysql_str="UPDATE code SET collectnum = collectnum+1 WHERE codeid={$codeid}";
            $codeData=$this->getCodeByCodeid_($codeid);
            if($codeData==false){
                return false;
            }
            return mysqli_query(self::$conn,$mysql_str);
        }
        function collectCodeMinus1($codeid){//图片收藏量-1 操作失败 return false
            $mysql_str="UPDATE code SET collectnum = collectnum-1 WHERE codeid={$codeid}";
            $codeData=$this->getCodeByCodeid_($codeid);
            if($codeData==false){
                return false;
            }
            return mysqli_query(self::$conn,$mysql_str);
        }
//==========================picc表
        function getPiccPicidByUserid($userid){ //返回 picids{[0]=>36,[1]=>40...}
            $mysql_str="SELECT picid FROM picc WHERE userid={$userid}";
            $data=mysqli_query(self::$conn,$mysql_str);
            $picids=Array();
            while($row = mysqli_fetch_assoc($data)){
                $picids[count($picids)]=$row["picid"];
            }
            return $picids;
        }
        function isInCollectPicc($userid,$picid){
            $result = $this->get1Result("picc",["picid"=>$picid,"userid"=>$userid]);
            if($result) logvarM("已收藏");
            return $result;
        }
        function addCollectPicc($userid,$picid,$customname){
            logvarM("addCollectPicc");
            $collectTime=time();
            $mysql_str="INSERT INTO picc VALUE ($userid,$picid,'$customname',$collectTime)";
            logvarM($mysql_str,"mysql_str");
            return mysqli_query(self::$conn,$mysql_str);
        }

        function deleteCollectPicc($userid,$picid){
            logvarM("deleteCollectPicc");
            $mysql_str="DELETE FROM picc WHERE userid = $userid and picid = $picid";
            logvarM($mysql_str,"mysql_str");
            $data=mysqli_query(self::$conn,$mysql_str);
            logvarM($data,"data");
            return $data;
        }
        // function 
//==========================Codec表
    function getCodecCodeidByUserid($userid){ //返回 codeids{[0]=>36,[1]=>40...}
        $mysql_str="SELECT codeid FROM codec WHERE userid={$userid}";
        $data=mysqli_query(self::$conn,$mysql_str);
        $codeids=Array();
        while($row = mysqli_fetch_assoc($data)){
            $codeids[count($codeids)]=$row["codeid"];
        }
        return $codeids;
    }
    function isInCollectCodec($userid,$codeid){
        $result = $this->get1Result("codec",["codeid"=>$codeid,"userid"=>$userid]);
        if($result) logvarM("已收藏");
        return $result;
    }
    function addCollectCodec($userid,$codeid,$customname){
        logvarM("addCollectcodec");
        $collectTime=time();
        $mysql_str="INSERT INTO codec VALUE ($userid,$codeid,'$customname',$collectTime)";
        logvarM($mysql_str,"mysql_str");
        return mysqli_query(self::$conn,$mysql_str);
    }

    function deleteCollectCodec($userid,$codeid){
        logvarM("deleteCollectcodec");
        $mysql_str="DELETE FROM codec WHERE userid = $userid and codeid = $codeid";
        logvarM($mysql_str,"mysql_str");
        $data=mysqli_query(self::$conn,$mysql_str);
        logvarM($data,"data");
        return $data;
    }
//==========================fans表
        function getUpidsByFansid($fansid){
            $mysql_str="SELECT upid FROM fans WHERE fansid={$fansid}";
            $data=mysqli_query(self::$conn,$mysql_str);
            $upids=Array();
            while($row = mysqli_fetch_assoc($data)){
                $upids[count($upids)]=$row["upid"];
            }
            return $upids;
        }
        function isFans($upid,$fansid){
            $result = $this->get1Result("fans",["upid"=>$upid,"fansid"=>$fansid]);
            if($result) logvarM("关注");
            return $result;
        }
        function addFans($upid,$fansid){
            // logvarM("addFans");
            $subscribetime=time();
            $mysql_str="INSERT INTO fans VALUE ($upid,$fansid,$subscribetime)";
            // logvarM($mysql_str,"mysql_str");
            return mysqli_query(self::$conn,$mysql_str);
        }
        function deleteFans($upid,$fansid){
            $mysql_str=" DELETE FROM fans WHERE upid={$upid} AND fansid={$fansid}";
            logvarM($mysql_str);
            return mysqli_query(self::$conn,$mysql_str);
        }

        function getFansidsByUpid($upid){
            $mysql_str="SELECT fansid FROM fans WHERE upid={$upid}";
            $data=mysqli_query(self::$conn,$mysql_str);
            $fansids=Array();
            while($row = mysqli_fetch_assoc($data)){
                $fansids[count($fansids)]=$row["fansid"];
            }
            return $fansids;
        }
//==========================picreply
        function getPicreplyByPicid($picid){
            $mysql_str="SELECT * FROM picreply WHERE picid={$picid}";
            $result=$this->getRowsByMysql_str($mysql_str);
            return $result;
        }
        function addPicreply($userid,$picid,$content){
            $time=time();
            $mysql_str0="SELECT IFNULL((SELECT MAX(floor) FROM picreply WHERE picid=$picid) , 0)+1 as floor";
            $floor=mysqli_fetch_assoc(mysqli_query(self::$conn , $mysql_str0))["floor"];
            $mysql_str="INSERT INTO picreply VALUE ($userid,$picid, $floor , '$content',$time)";
            return mysqli_query(self::$conn,$mysql_str);
        }
//==========================codereply
        function getCodereplyByCodeid($codeid){
            $mysql_str="SELECT * FROM codereply WHERE codeid={$codeid}";
            $result=$this->getRowsByMysql_str($mysql_str);
            return $result;
        }
        function addCodereply($userid,$codeid,$content){
            $time=time();
            $mysql_str0="SELECT IFNULL((SELECT MAX(floor) FROM codereply WHERE codeid=$codeid) , 0)+1 as floor";
            $floor=mysqli_fetch_assoc(mysqli_query(self::$conn , $mysql_str0))["floor"];
            // var_dump($floor);
            $mysql_str="INSERT INTO codereply VALUE ($userid,$codeid, $floor , '$content',$time)";
            // var_dump($mysql_str);
            return mysqli_query(self::$conn,$mysql_str);
        }
//==========================杂
    //======================图片收藏相关
        function collectPic($userid,$picid,$customname){
            //判断有没有收藏  
            //    ? 判断有没有图片 +1成不成功
            //        ? 收藏 picc 增加一条记录;
            //          ? return true : return false;
            //        : return false
            //    : return false
            if(!$this->isInCollectPicc($userid,$picid)){//判断有没有收藏  
                if($this->collectPicAdd1($picid)){//判断有没有图片 +1成不成功
                    if($this->addCollectPicc($userid,$picid,$customname)){
                        return true;
                    }else{
                        $this->collectPicMinus1($picid);
                    }
                }
            }
            return false;
        }
        function deleteCollectPic($userid,$picid){
            if($this->isInCollectPicc($userid,$picid)){
                if($this->deleteCollectPicc($userid,$picid)){
                    $this->collectPicMinus1($picid);
                    return true;
                }
            }
            return false;
        }
        function showCollectPic($userid){
            $picids = $this->getPiccPicidByUserid($userid);
            $result=$this->getPicsByPicids($picids);
            return $result;
        }
    //======================代码收藏相关
        function collectCode($userid,$codeid,$customname){
            //判断有没有收藏  
            //    ? 判断有没有图片 +1成不成功
            //        ? 收藏 codec 增加一条记录;
            //          ? return true : return false;
            //        : return false
            //    : return false
            if(!$this->isInCollectCodec($userid,$codeid)){//判断有没有收藏  
                if($this->collectCodeAdd1($codeid)){//判断有没有图片 +1成不成功
                    if($this->addCollectCodec($userid,$codeid,$customname)){
                        return true;
                    }else{
                        $this->collectCodeMinus1($codeid);
                    }
                }
            }
            return false;
        }
        function deleteCollectCode($userid,$codeid){
            if($this->isInCollectCodec($userid,$codeid)){
                if($this->deleteCollectCodec($userid,$codeid)){
                    $this->collectCodeMinus1($codeid);
                    return true;
                }
            }
            return false;
        }
        function showCollectCode($userid){
            $codeids = $this->getCodecCodeidByUserid($userid);
            $result=$this->getCodesByCodeids($codeids);
            return $result;
        }
    //=====================粉丝关注相关
        function subscribe($upid,$fansid){
            if(!$this->isFans($upid,$fansid)){
                if($this->fansAdd1($upid)){
                    if($this->addFans($upid,$fansid)){
                        return true;
                    }else{
                        $this->fansMinus1($upid);
                    }
                }
            }
            return false;
        }
        function unsubscribe($upid,$fansid){
            if($this->isFans($upid,$fansid)){
                if($this->deleteFans($upid,$fansid)){
                    $this->fansMinus1($upid);
                    return true;
                }
            }
            return false;
        }
        function getUpsByFansid($fansid){
            $upids=$this->getUpidsByFansid($fansid);
            $result=$this->getUsersByUserids($upids);
            return $result;
        }
        function getFansByUpid($fansid){
            $upids=$this->getFansidsByUpid($fansid);
            $result=$this->getUsersByUserids($upids);
            return $result;
        }
    //======================XXXX相关
//==========================test
        function test(){

        }
    }
?>