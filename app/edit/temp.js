myCode={
    DrawPic(){
        let a=myArguments.a.val;
        let b=myArguments.b.val;
        let w=el_mycanvas.width;
        let h=el_mycanvas.height;
        ctx.fillStyle="#fff";
 
        h*=Math.abs(Math.sin(new Date().getTime()/1000))

        for(let i=0; i<w;i+=a){
            for(let j=0; j<h;j+=a){
                ctx.fillRect(i,j,a/2,a/2);
            }
        }
        
    },
}


var DrawPic=function(){
    let a=myArguments.a.val;
    let b=myArguments.b.val;
    let w=edit.el.mycanvas.width;
    let h=edit.el.mycanvas.height;
    ctx.fillStyle="#fff";

    h*=Math.abs(Math.sin(new Date().getTime()/1000))

    for(let i=0; i<w;i+=a){
        for(let j=0; j<h;j+=a){
            ctx.fillRect(i,j,a/2,a/2);
        }
    }
}

