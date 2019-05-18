var log=console.log;
var DrawLoop=false;
function newCode(codeId,codeName,picPath,codeStrFromMysql,id){
    var edit={
        el:{
            myName:["edit","el"],
            argumentsBox:undefined, 
            mycanvas:undefined, 
            pic:undefined, 
            loop:undefined,
            Init(){
                let t=this;
                // t.argumentsBox=document.getElementById("argumentsBox");
                t.a=document.createElement("a");
                t.codeBox=document.createElement("div");
                t.leftBox=document.createElement("div");
                t.rightBox=document.createElement("div");
                t.clearFloat=document.createElement("div");
                t.codeInfo=document.createElement("div");
                t.pic=document.createElement("img");
                t.mycanvas=document.createElement("canvas");
                t.pic.src=picPath;
                t.a.href="/code/"+codeId;
                t.codeInfo.innerHTML=codeName;

                t.leftBox.append(t.pic);
                t.rightBox.append(t.mycanvas);
                t.codeBox.append(t.leftBox);
                t.codeBox.append(t.rightBox);
                t.codeBox.append(t.rightBox);
                t.codeBox.append(t.clearFloat);
                t.codeBox.append(t.codeInfo);
                t.a.append(t.codeBox);
                document.getElementsByClassName("codeBigBox")[0].append(t.a);


                t.pic.onload=function(){
                    globalData[id].edit.draw.Init();
                    globalData[id].userCode.Init();

                    t.codeBox.className="codeBox";
                    t.leftBox.className="code-picBox";
                    t.rightBox.className="code-picBox";
                    t.codeInfo.className="codeInfo";
                    t.clearFloat.style.clear="both";
                }
                // t.loop=document.getElementById("loop");

                // t.codeText=document.getElementById("codeText");  
                // t.argumentsBox=document.getElementById("argumentsBox");
                // t.mycanvas=document.getElementById("mycanvas");  
                // t.pic=document.getElementById("pic");
                // t.loop=document.getElementById("loop");

            }
        },

        draw:{
            ctx:undefined,
            
            Init(){
                this.ctx=edit.el.mycanvas.getContext("2d");
                edit.draw.DrawPic(this);
            },
            DrawPic(){//初始 预备工作
                let ctx=edit.draw.ctx;
                let el=edit.el;
                console.log(picPath,el.pic.width,el.pic.height,el.pic)
                el.mycanvas.width=el.pic.width;
                el.mycanvas.height=el.pic.height;
                ctx.drawImage(el.pic,0,0);
                userCode.DrawPic();
                if(DrawLoop){
                    setTimeout(edit.draw.DrawPic,1000/60);
                }
            },
        }
    }

    var userCode={
        
        userCodeStr:(()=>
        {   return codeStrFromMysql
        })(),
        codePre:(()=>{//代码头 主要提供用户代码可以使用的数据
            return `
            var ctx=globalData[`+id+`].edit.draw.ctx;
            var edit=globalData[`+id+`].edit;
            var mycanvas=globalData[`+id+`].edit.el.mycanvas;
            var userField={};
        `})(),
        codeLast:"; return [DrawPic,userField]",
        GetField(Fields){
            for(var key in userCode.userField){
                delete userCode.userField[key];
            }
            for(var key in Fields){
                userCode.userField[key]=Fields[key];
            }
        },
        RunCode(){
            // (new Function("log(edit)"))();
            // var f=new Function("log(edit)");
            // f();
            var el=edit.el;
            console.log(userCode.codePre+userCode.userCodeStr+userCode.codeLast);
            var fun=new Function(userCode.codePre+userCode.userCodeStr+userCode.codeLast);
            var data=fun();
            userCode.DrawPic=data[0];
            userCode.GetField(data[1]);

            edit.draw.DrawPic(edit.draw);
        },
        DrawPic(){
            this.userFun.DrawPic();
        },
        
        userField:{
            a:{type:"num",val:10},
            b:{type:"num",val:10}
        },
        userFun:{
            DrawPic(){
                log("myCode.DrawPic")
            },
        },
        Init(){
            userCode.RunCode();
            // try{
            //     userCode.RunCode();
            // }catch(e){
            //     console.error(e)
            //     alert("代码错误 停止运行")
            // }
        },
    }

    var idInArr=id;

    return {
        "edit":edit,
        "userCode":userCode,
        "idInArr":idInArr,
    }
}
var globalData=[];
var edit;
var userCode;

// var mysqlData=[{"codename":"code1","picpath":'/file/pic/1555974522.png',"codecontent":`var myArguments = {
//     a:{type:"num",val:5},
//     b:{type:"num",val:5},
//     c:{type:"text",var:"it is c"}
// };
// var DrawPic=function(){
//     let a=myArguments.a.val;
//     let b=myArguments.b.val;
//     let w=edit.el.mycanvas.width;
//     let h=edit.el.mycanvas.height;
//     ctx.fillStyle="#fff";

//     //h*=Math.abs(Math.sin(new Date().getTime()/1000));
//     h*=1;
//     for(let i=0; i<w;i+=a){
//         for(let j=0; j<h;j+=a){
//             ctx.fillRect(i,j,a/2,a/2);
//         }
//     }
// }`},{"codename":"无名代码","picpath":'/file/pic/1555974522.png',"codecontent":`var myArguments = {
//     a:{type:"num",val:15},
//     b:{type:"num",val:15},
//     c:{type:"text",var:"it is c"}
// };
// var DrawPic=function(){
//     let a=myArguments.a.val;
//     let b=myArguments.b.val;
//     let w=edit.el.mycanvas.width;
//     let h=edit.el.mycanvas.height;
//     ctx.fillStyle="#fff";

//     //h*=Math.abs(Math.sin(new Date().getTime()/1000));
//     h*=1;
//     for(let i=0; i<w;i+=a){
//         for(let j=0; j<h;j+=a){
//             ctx.fillRect(i,j,a/2,a/2);
//         }
//     }
// }
// `},];

// var mysqlData=[
//     {"codename":"code1",
//     "picpath":"/file/pic/0.jpg",
//     "codecontent":`userField = {
//         a:{type:"num",val:5},
//         b:{type:"num",val:5},
//         c:{type:"text",val:"#050"}
//     };
//     var DrawPic=function(){
//         let a=userField.a.val;
//         let b=userField.b.val;
//         let w=mycanvas.width;
//         let h=mycanvas.height;
//         ctx.fillStyle=userField.c.val;
    
//         //h*=Math.abs(Math.sin(new Date().getTime()/1000));
//         h*=1;
//         for(let i=0; i<w;i+=a){
//             for(let j=0; j<h;j+=a){
//                 ctx.fillRect(i,j,a/2,a/2);
//             }
//         }
//     }`},
//     {"codename":"code2",
//     "picpath":"pic1.jpg",
//     "codecontent":`userField = {
//         a:{type:"num",val:35},
//         b:{type:"num",val:5},
//         c:{type:"text",val:"#050"}
//     };
//     var DrawPic=function(){
//         let a=userField.a.val;
//         let b=userField.b.val;
//         let w=mycanvas.width;
//         let h=mycanvas.height;
//         ctx.fillStyle=userField.c.val;
    
//         //h*=Math.abs(Math.sin(new Date().getTime()/1000));
//         h*=1;
//         for(let i=0; i<w;i+=a){
//             for(let j=0; j<h;j+=a){
//                 // ctx.fillRect(i,j,a/2,a/2);
//                 ctx.clearRect(i,j,a/2,a/2);
//             }
//         }
//     }`},
// ]
window.onload=Init();
function Init(){
    // edit.el.Init();
    // edit.draw.Init();
    // userCode.Init();
    for(var i=0;i<mysqlData.length;i++){
        globalData[i]=newCode(
            mysqlData[i].codeid,
            mysqlData[i].codename,
            mysqlData[i].picpath,
            mysqlData[i].codecontent,
            i);
        globalData[i].edit.el.Init();
    }
    var clearFloatEL=document.createElement("div");
    clearFloatEL.style="clear:both"
    document.getElementsByClassName("codeBigBox")[0].append(clearFloatEL);

}


