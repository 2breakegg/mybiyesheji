 //获取当前页面的地址 以及userid参数
 function getUrl(page){
    var h = document.location;
    var r = h.origin+h.pathname;

    var searchParams = (new URLSearchParams(h.search)).entries();
    
    for(var pair of searchParams) {
        if(pair[0]=="userid"){
            r+=`?${pair[0]}=${pair[1]}&`;
            break;
        }
    }
    self.location=`${r}page=${page}`
    // return r;
}

function getPage(){
    let page="info";
    let searchParams = (new URLSearchParams(document.location.search)).entries();
    
    for(let pair of searchParams) {
        if(pair[0]=="page"){
            page=pair[1];
            break;
        }
    }
    return page;
}

function tagSelected(page){
    document.getElementById(page+"Tab").classList.add("selected");
}

function init(){
    let page=getPage();

    tagSelected(page);
}
init();
// getUrl(info);