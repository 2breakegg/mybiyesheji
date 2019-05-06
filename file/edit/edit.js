var log=console.log;
var DrawLoop=false;

var edit={
    el:{
        myName:["edit","el"],
        codeText:undefined, 
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
            t.codeText=document.getElementById("codeText");  
            t.argumentsBox=document.getElementById("argumentsBox");
            t.mycanvas=document.getElementById("mycanvas");  
            t.pic=document.getElementById("pic");
            t.loop=document.getElementById("loop");


            t.pic.onload=function(){
                console.log("t.pic.onload");
                edit.draw.Init();
            }

            t.codeText.addEventListener("keydown",(e)=>{
                if(e.key=="Enter" && e.ctrlKey==true){
                    userCode.RunCode();
                }
            });
        }
    },

    draw:{
        ctx:undefined,
        
        Init(){
            this.ctx=edit.el.mycanvas.getContext("2d");
            userCode.Init();
            edit.draw.DrawPic();
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
    
    userCodeStr:mysqlData.codecontent,
    codePre:(()=>{//代码头 主要提供用户代码可以使用的数据
        return `
        var ctx=edit.draw.ctx;
        var mycanvas=edit.el.mycanvas;
        var input=userCode.userField;
    `})(),
    codeLast:"; return [DrawPic,userField]",
    GetCode(){
        userCode.userCodeStr=edit.el.codeText.value;
    },
    GetField(Fields){
        for(var key in userCode.userField){
            delete userCode.userField[key];
        }
        for(var key in Fields){
            userCode.userField[key]=Fields[key];
        }
        this.ShowInput();
    },
    RunCode(){
        try{
            var el=edit.el;
            this.GetCode();
            console.log(userCode.codePre+userCode.userCodeStr+userCode.codeLast);
            var fun=new Function(userCode.codePre+userCode.userCodeStr+userCode.codeLast);
            var data=fun();
            userCode.DrawPic=data[0];
            userCode.GetField(data[1]);

            el.GetParent().draw.DrawPic(el.GetParent().draw);
        }catch(e){
            console.error(e)
            alert("代码错误 停止运行")
        }
    },
    DrawPic(){
        this.userFun.DrawPic();
    },
    
    ShowInput(){//获取自定义数据的结构 然后通过结构在网页上显示输入框, 可以让用户自定义数据
        var myArguments=this.userField;
        edit.el.argumentsBox.innerHTML="";
        Object.keys(myArguments).forEach(function(key){
            let el2_arguments=document.createElement("p");
            let el2_label=document.createElement('span');
            let el2_input=document.createElement('input');
        
            el2_input.type="text";
            el2_input.addEventListener("keydown",e=>{
                log("keyDown");
                if(e.key=="Enter"){
                    log("Enter");
                    if(myArguments[key].type=="num"){
                        myArguments[key].val= Number.parseFloat(el2_input.value);
                    }else{
                        myArguments[key].val=el2_input.value;
                    }
                    edit.draw.DrawPic();
                }
            })
            el2_label.innerText=key;
            el2_input.value=myArguments[key].val;
            el2_arguments.appendChild(el2_label);
            el2_arguments.appendChild(el2_input);
            edit.el.argumentsBox.appendChild(el2_arguments);
            log(key,myArguments[key]);
        });
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

    showCode(){
        edit.el.codeText.value=this.userCodeStr;
    },
    Init(){
        this.showCode();
        this.RunCode();
    },
}


window.onload=Init();
function Init(){
    edit.el.Init();
}


