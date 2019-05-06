// myCode={
//     DrawPic(){
//         let a=myArguments.a.val;
//         let b=myArguments.b.val;
//         let w=el_mycanvas.width;
//         let h=el_mycanvas.height;
//         ctx.fillStyle="#fff";
 
//         h*=Math.abs(Math.sin(new Date().getTime()/1000))

//         for(let i=0; i<w;i+=a){
//             for(let j=0; j<h;j+=a){
//                 ctx.fillRect(i,j,a/2,a/2);
//             }
//         }
        
//     },
// }
//================================
var userField = {
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
}


//================================
var userField = {
    font_size:{type:"num",val:5},
};
var DrawPic=function(){
    // var canvas=this.canvas;
    var size=userField.font_size.val;
    var data=ctx.getImageData(0,0,mycanvas.width,mycanvas.height).data;
    var chars="．＇＿＿＿；；；～～～＊＊＝！＾＾＾／／／（（］］７二二１１１１３３２十十十三三了９９００＄士士小千８飞飞大大几计％＆＆从从手方车车生生开价乐乐乐涉涉涉考及＠这这些些发机快快间地的的浪角阿师我四就就弹度速联联德顿看看费费算算算榴榴圖";

    ctx.font=size+"px "+this.font_family;
    ctx.textAlign="start";      
    ctx.textBaseline="hanging";
    
    var w=Math.floor(mycanvas.width/size);
    var h=Math.floor(mycanvas.height/size);
    
    var top,left,top2,left2,pxId,pxId2,graw_level,char_line,char;
    for(top=0;top<h;top++){
        char_line="";
        for(left=0;left<w;left++){
            graw_level=0;
            pxId=mycanvas.width*size*top+left*size;
            //获取块黑白值
            for(top2=0;top2<size;top2++){
                for(left2=0;left2<size;left2++){
                    pxId2=pxId+top2*mycanvas.width+left2;
                    graw_level+=data[pxId2*4];
                    graw_level+=data[pxId2*4+1];
                    graw_level+=data[pxId2*4+2];
                }
            }
            graw_level=Math.floor((graw_level/size/size/3)/256*chars.length);
            charId=chars.length-1-graw_level
            char=chars[charId];
            if(char==undefined){
                console.log(graw_level,charId);
            }
            char_line+=char;
            //console.log(Math.floor(graw_level/this.char.length));
        }
        ctx.fillStyle="#ffffff";
        // ctx.clearRect(0,top*size,this.video_width,(top+1)*size);
        ctx.fillRect(0,top*size,mycanvas.width,(top+1)*size);
        ctx.fillStyle="#000000";
        ctx.fillText(char_line,0,top*size); 
    }
}


//====================================
var userField = {
    font_size:{type:"num",val:5},
};
var DrawPic=function(){
    var size=userField.font_size.val;
    var imageData=ctx.getImageData(0,0,mycanvas.width,mycanvas.height)
    var data=imageData.data;
    
    var w=Math.floor(mycanvas.width/size);
    var h=Math.floor(mycanvas.height/size);
    
    var top,left,top2,left2,pxId,pxId2,rgb,char_line,char;
    for(top=0;top<h;top++){
        char_line="";
        for(left=0;left<w;left++){
            rgb=[0,0,0];
            pxId=mycanvas.width*size*top+left*size;
            //获取块黑白值
            for(top2=0;top2<size;top2++){
                for(left2=0;left2<size;left2++){
                    pxId2=pxId+top2*mycanvas.width+left2;
                    rgb[0]+=data[pxId2*4];
                    rgb[1]+=data[pxId2*4+1];
                    rgb[2]+=data[pxId2*4+2];
                }
            }

            rgb[0]=(rgb[0]/size/size)|0;
            rgb[1]=(rgb[1]/size/size)|0;
            rgb[2]=(rgb[2]/size/size)|0;
            for(top2=0;top2<size;top2++){
                for(left2=0;left2<size;left2++){
                    pxId2=pxId+top2*mycanvas.width+left2;
                    data[pxId2*4]=rgb[0];
                    data[pxId2*4+1]=rgb[1];
                    data[pxId2*4+2]=rgb[2];
                }
            }
            //console.log(Math.floor(graw_level/this.char.length));
        }
    }
    ctx.putImageData(imageData,0,0);
}


//================================灭霸

const DEBUG = false;
const REPETITION_COUNT = 2; // number of times each pixel is assigned to a canvas
const NUM_FRAMES = 128;

/**
 * Generates the individual subsets of pixels that are animated to create the effect
 * @param {HTMLCanvasElement} ctx
 * @param {number} count The higher the frame count, the less grouped the pixels will look - Google use 32, but for our elms we use 128 since we have images near the edges
 * @return {HTMLCanvasElement[]} Each canvas contains a subset of the original pixels
 */
function generateFrames($canvas, count = 32) {
  const { width, height } = $canvas;
  const ctx = $canvas.getContext("2d");
  const originalData = ctx.getImageData(0, 0, width, height);
  const imageDatas = [...Array(count)].map(
    (_,i) => ctx.createImageData(width, height)
  );
  
  // assign the pixels to a canvas
  // each pixel is assigned to 2 canvas', based on its x-position
  for (let x = 0; x < width; ++x) {
    for (let y = 0; y < height; ++y) {
      for (let i = 0; i < REPETITION_COUNT; ++i) {
        const dataIndex = Math.floor(
          count * (Math.random() + 2 * x / width) / 3
        );
        const pixelIndex = (y * width + x) * 4;
        // copy the pixel over from the original image
        for (let offset = 0; offset < 4; ++offset) {
          imageDatas[dataIndex].data[pixelIndex + offset]
            = originalData.data[pixelIndex + offset];
        }
      }
    }
  }
  
  // turn image datas into canvas'
  return imageDatas.map(data => {
    const $c = $canvas.cloneNode(true);
    $c.getContext("2d").putImageData(data, 0, 0);
    return $c;
  });
}

/**
 * Inserts a new element over an old one, hiding the old one
 */
function replaceElementVisually($old, $new) {
  const $parent = $old.offsetParent;
  $new.style.top = `${$old.offsetTop}px`;
  $new.style.left = `${$old.offsetLeft}px`;
  $new.style.width = `${$old.offsetWidth}px`;
  $new.style.height = `${$old.offsetHeight}px`;
  $parent.appendChild($new);
  $old.style.visibility = "hidden";
}

/**
 * Disintegrates an element
 * @param {HTMLElement} $elm
 */
function disintegrate($elm) {
  html2canvas($elm).then($canvas => {    
    // create the container we'll use to replace the element with
    const $container = document.createElement("div");
    $container.classList.add("disintegration-container");
    
    // setup the frames for animation
    const $frames = generateFrames($canvas, NUM_FRAMES);
    $frames.forEach(($frame, i) => {
      $frame.style.transitionDelay = `${1.35 * i / $frames.length}s`;
      $container.appendChild($frame);
    });
    
    // then insert them into the DOM over the element
    replaceElementVisually($elm, $container);
    
    // then animate them
    $container.offsetLeft; // forces reflow, so CSS we apply below does transition
    if (!DEBUG) {
      // set the values the frame should animate to
      // note that this is done after reflow so the transitions trigger
      $frames.forEach($frame => {
        const randomRadian = 2 * Math.PI * (Math.random() - 0.5);
        $frame.style.transform = 
          `rotate(${15 * (Math.random() - 0.5)}deg) translate(${60 * Math.cos(randomRadian)}px, ${30 * Math.sin(randomRadian)}px)
rotate(${15 * (Math.random() - 0.5)}deg)`;
			  $frame.style.opacity = 0;
      });
    } else {
      $frames.forEach($frame => {
        $frame.style.animation = `debug-pulse 1s ease ${$frame.style.transitionDelay} infinite alternate`;
      });
    }
  });
}


/** === Below is just to bind the module and the DOM == */
[...document.querySelectorAll(".disintegration-target")].forEach($elm => {
  $elm.addEventListener("click", () => {
    if ($elm.disintegrated) { return; }
    $elm.disintegrated = true;
    disintegrate($elm);
  });
});