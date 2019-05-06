var log=console.log;
var DrawLoop=false;

var edit={
    el:{
        myName:["edit","el"],
        argumentsBox:undefined, 
        mycanvas:undefined, 
        pic:undefined, 
        loop:undefined,
        GetParent(){
            var myParent=window;
            for(var i=0;i<this.myName.length-1;i++){
                myParent=myParent[this.myName[i]]
            }
            return myParent
        },
        Init(){
            let t=this;
            // t.argumentsBox=document.getElementById("argumentsBox");
            t.codeBox=document.createElement("div");
            t.pic=document.createElement("img");
            t.mycanvas=document.createElement("canvas");  
            t.pic.src="pic1.jpg";

            t.codeBox.append(t.pic);
            t.codeBox.append(t.mycanvas);
            document.body.append(t.codeBox);
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
            let el=edit.el
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
    {   return`var userField = {
        a:{type:"num",val:5},
        b:{type:"num",val:5},
        c:{type:"text",val:"it is c"}
    };
    var DrawPic=function(){
        let a=userField.a.val;
        let b=userField.b.val;
        let w=edit.el.mycanvas.width;
        let h=edit.el.mycanvas.height;
        ctx.fillStyle="#fff";
    
        //h*=Math.abs(Math.sin(new Date().getTime()/1000));
        h*=1;
        for(let i=0; i<w;i+=a){
            for(let j=0; j<h;j+=a){
                ctx.fillRect(i,j,a/2,a/2);
            }
        }
    }`
    })(),
    codePre:(()=>{//代码头 主要提供用户代码可以使用的数据
        return `
        var ctx=edit.draw.ctx;
        var input=userCode.userField;
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
        var el=edit.el;
        console.log(userCode.codePre+userCode.userCodeStr+userCode.codeLast);
        var fun=new Function(userCode.codePre+userCode.userCodeStr+userCode.codeLast);
        var data=fun();
        userCode.DrawPic=data[0];
        userCode.GetField(data[1]);

        el.GetParent().draw.DrawPic(el.GetParent().draw);
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
        try{
            userCode.RunCode();
        }catch(e){
            console.error(e)
            alert("代码错误 停止运行")
        }
    },
}


window.onload=Init();
function Init(){
    edit.el.Init();
    edit.draw.Init();
    userCode.Init();
}


