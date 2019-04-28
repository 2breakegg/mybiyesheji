<?php
    require_once $ConfPath["mymodel"];
    class Upload_Pic{
        var $imgPathName; //服务器存在地址 图片保存保存的路径,以及文件名 不包括后缀
        var $imgPathUrl; //url地址
        var $myModel;
        function init(){
            $this->myModel = MyModel::getInstance();
            $this->imgPathUrl = "/file/pic/".time().".";
            $this->imgPathName = WWWROOT.$this->imgPathUrl;
            
            if(!isset($_POST["type"])){
                return;
            }
            $type=$_POST["type"];
            if($type=="add"){
                $this->addPic();
                // $this->uploadPic();
            }
        }
        //添加数据库消息
        function addPic(){
            $this->uploadPic();
            $imgPathName_FULL = $this->imgPathUrl.explode("/", $_FILES["img"]["type"])[1];
            if($imgPathName_FULL!=null){
                $picname=$_POST["picname"];
                $picpath=$imgPathName_FULL;
                $userid=$_COOKIE["userid"];
                $uploadtime=time();

                $this->myModel->addPic($picname,$picpath,$userid,$uploadtime);
            }
        }
        //上传保存图片文件
        function uploadPic(){
            $imgname=null; //图片全名
            logvar($_FILES,"_FILES"); // 区别于$_POST、$_GET
            // print_r($_FILES);
            $file = $_FILES["img"];
            // 先判断有没有错
            if ($file["error"] == 0) {
                // 成功 
                // 判断传输的文件是否是图片，类型是否合适
                // 获取传输的文件类型
                $typeArr = explode("/", $file["type"]);
                logvar($typeArr,"typeArr");
                if($typeArr[0]== "image"){
                    // 如果是图片类型
                    $imgType = array("png","jpg","jpeg");
                    if(in_array($typeArr[1], $imgType)){ // 图片格式是数组中的一个
                        // 类型检查无误，保存到文件夹内
                        // 给图片定一个新名字 (使用时间戳，防止重复)
                        $imgname = $this->imgPathName.$typeArr[1];
                        // 将上传的文件写入到文件夹中
                        // 参数1: 图片在服务器缓存的地址
                        // 参数2: 图片的目的地址（最终保存的位置）
                        // 最终会有一个布尔返回值
                        loge2($imgname,"imgname");
                        loge2($typeArr[1],"typeArr[1]");
                        loge2($this->imgPathName,"this->imgPathName");
                        $bol = move_uploaded_file($file["tmp_name"], $imgname);
                        if($bol){
                            echo "上传成功！";
                        } else {
                            $imgname=null;
                            echo "上传失败！";
                        };
                    };
                } else {
                    // 不是图片类型
                    echo "没有图片，再检查一下吧！";
                };
            } else {
                // 失败
                echo $file["error"];
            };
            loge2($imgname,"imgname");

            return $imgname;
        }
    }
    $upload_Pic=new Upload_Pic;
    $upload_Pic->init();
    
?>
<div>
    <button id="uploadPic_ShowUploadFormButton" type="button">上传图片</button>
    <div id="uploadPic_UploadForm">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="add"/>
            <label for="findimg"> 选择要上传的图片:</label> <input id="findimg" type="file" name="img"/><br/>
            <label for="picname">图片名称:</label> <input id="picname" name="picname" type="text" >
            <input type="submit" value="上传"/>
        </form>
        <button id="uploadPic_HideUploadFormButton" type="button">返回</button>
    </div>
</div>

<script>
    function uploadPicShowHidden(show, hidden){
        console.log(show);
        console.log(hidden);

        show.style.display="block";
        hidden.style.display="none";
    }
    function uploadPicInit(){
        var elShow = document.getElementById("uploadPic_ShowUploadFormButton");
        var elHide = document.getElementById("uploadPic_HideUploadFormButton");
        var elForm = document.getElementById("uploadPic_UploadForm");
        elShow.addEventListener("click",function(){uploadPicShowHidden(elForm, elShow)});
        elHide.addEventListener("click",function(){uploadPicShowHidden(elShow, elForm)});
        uploadPicShowHidden(elShow, elForm);
    }
    uploadPicInit();
</script>