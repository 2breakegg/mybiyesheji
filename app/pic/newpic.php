<!-- 上传图片 -->
<img src="" alt="" id="pic">
<form action="/pic/uploadpic" method="post" enctype="multipart/form-data">
    <input type="hidden"  value="add"/>
    <label for="findimg"> 选择要上传的图片:</label> <input id="findimg" type="file" name="img"/><br/>
    <label for="picname">图片名称:</label> <input id="picname" name="picname" type="text" >
    <input type="submit" name="type" value="上传图片"/>
</form>
<script>
    var f=document.getElementById("findimg")
    f.onchange=function(){
        var img=this.files[0];
        var fr=new FileReader();
        fr.onload=function(){
            document.getElementById("pic").src=fr.result;
        }
        fr.readAsDataURL(img);
    }
</script>