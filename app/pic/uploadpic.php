<!-- //uploadpic.php -->
<?php
    require_once $ConfPath["top"];
    require_once $ConfPath["mymodel"];
    class UploadPic{
        static function init(){
            $type=$_POST["type"];
            if($type=="修改名称"){
                self::modifyPic();
            }else if($type=="上传图片"){
                self::addPic();
            }else if($type=="删除图片"){
                self::deletePic();
            }
        }

        static function modifyPic(){
            $picid=$_POST["picid"];
            $picname=$_POST["picname"];
            $userid=$_COOKIE["userid"];
            if(MyModel::getInstance()->modifyPic($picid,$picname,$userid)){
                echo "修改成功";
            }else{
                echo "修改失败";
            }
        }
        
        static function addPic(){ 
                                            //↓----------- 是图片 ?---------↓
                                    // ↓------是                          不是↓
                        //↓------ 保存图片到硬盘 ----↓                echo 图片上传失败
                        //成功↓                      失败---------------------↑
            //      ↓--添加到数据库-----↓                                      |
            //     成功↓               失败↓                                  |
            //echo 图片上传成功      删除以保存的图片---------------------------|

            $picType=self::getPicType();
            if($picType){//保存图片到硬盘
                $picPathUrl="/file/pic/".time().".".$picType;
                $picPathDisk=WWWROOT.$picPathUrl;
                loge2("是图片,准备上传");
                $isAddFile = self::addPicFile($picPathDisk);
                if($isAddFile){//添加到数据库
                    $picname=$_POST["picname"];
                    $picpath=$picPathUrl;
                    $userid=$_COOKIE["userid"];
                    $isMysql=MyModel::getInstance()->addPic($picname,$picpath,$userid);
                    if($isMysql!=false){//echo 图片上传成功
                        echo "图片上传成功";
                        return;
                    }else{//删除以保存的图片
                        self::deletePicFile($picPathDisk);
                    }
                }
            }
            
            echo "图片上传失败";
        }

        static function addPicFile($picPathDisk){//添加图片成功,返回true,否则flase
            $result = move_uploaded_file($_FILES["img"]["tmp_name"], $picPathDisk);
            if($bol){
                loge2("图片文件添加成功");
            }else{
                loge2("图片文件添加失败");
            }
            return $result;
        }

        static function deletePicFile($picPathDisk){ //
            $result=unlink($picPathDisk);
            if($result){
                loge2("图片文件删除成功");
            }else{
                loge2("图片文件删除成功");
            }
            return $result;
        }

        static function deletePic(){
            $picid=$_POST["picid"];
            $userid=$_COOKIE["userid"];
            $picPathDisk=WWWROOT.MyModel::getInstance()->getPicPathByPicid($picid);
            if(MyModel::getInstance()->deletePic($picid,$userid)){
                // echo $picPathDisk;
                self::deletePicFile($picPathDisk);
                echo "删除成功";
            }else{
                echo "删除失败";
            }
        }

        static function getPicType(){// 如果是图片 ? return图片后缀 : return false
            $file = $_FILES["img"];

            if ($file["error"] == 0) {
                $typeArr = explode("/", $file["type"]);
                logvar($typeArr,"typeArr");
                if($typeArr[0]== "image"){
                    // 如果是图片类型
                    $imgType = array("png","jpg","jpeg");
                    if(in_array($typeArr[1], $imgType)){ // 图片格式是数组中的一个
                        $result=$typeArr[1];
                        return $result;
                    };
                };
            }
            return false;
        }
    }

    UploadPic::init();
    // UploadPic::deletePicFile();
?>