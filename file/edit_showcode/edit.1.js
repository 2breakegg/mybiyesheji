var el_codeText, el_argumentsBox, el_mycanvas, el_pic, el_loop
var ctx;
var DrawLoop=true;
var myArguments={
    a:{type:"num",val:10},
    b:{type:"num",val:10}
}
var myCode={
    DrawPic(){
        console.log("myCode.DrawPic")
        ctx.fillRect(0,0,myArguments.a.val,myArguments.b.val);
    },
}
window.onload=init();

function init(){
    console.log("init")
    el_argumentsBox=document.getElementById("el_argumentsBox");
    el_codeText=document.getElementById("el_codeText");  
    el_mycanvas=document.getElementById("el_mycanvas");  
    el_pic=document.getElementById("el_pic");
    el_loop=document.getElementById("el_loop");

    ctx=el_mycanvas.getContext("2d");

    el_codeText.addEventListener("keydown",(e)=>{
        if(e.key=="Enter" && e.ctrlKey==true){
            eval(el_codeText.value);
            DrawPic();
            console.log("Enter")
        }
    });
    DrawPic();
}

function DrawPic(){
    el_mycanvas.width=el_pic.width;
    el_mycanvas.height=el_pic.height;
    ctx.drawImage(el_pic,0,0);
    myCode.DrawPic();
    if(DrawLoop){
        setTimeout(DrawPic,1000/60);
    }
}

function getArgumentsBox(){
    el_argumentsBox
    myArguments
}

Object.keys(myArguments).forEach(function(key){
    let el2_arguments=document.createElement("p");
    let el2_label=document.createElement('span');
    let el2_input=document.createElement('input');

    el2_input.type="text";
    el2_input.addEventListener("keydown",e=>{
        console.log("keyDown");
        if(e.key=="Enter"){
            console.log("Enter");
            if(myArguments[key].type=="num"){
                myArguments[key].val= Number.parseFloat(el2_input.value);
            }else{
                myArguments[key].val=el2_input.value;
            }
            DrawPic();
        }
    })
    el2_label.innerText=key;
    el2_input.value=myArguments[key].val;
    el2_arguments.appendChild(el2_label);
    el2_arguments.appendChild(el2_input);
    el_argumentsBox.appendChild(el2_arguments);
    console.log(key,myArguments[key]);

});
