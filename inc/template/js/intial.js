function loadScript(url, type,lfilename) {
    if (type == 'js') {
        var script = document.createElement("script");
        script.type = "text/javascript";

        if (script.readyState) {  //IE
            script.onreadystatechange = function () {
                if (script.readyState == "loaded" ||
                        script.readyState == "complete") {
                    script.onreadystatechange = null;
                    //callback();
                }
            };
        } else {  //Others
            script.onload = function () {
                //callback();
            };
        }
       
        script.src = url;
   
    } else {
        var script = document.createElement("link");
        script.rel = "stylesheet";

        if (script.readyState) {  //IE
            script.onreadystatechange = function () {
                if (script.readyState == "loaded" ||
                        script.readyState == "complete") {
                    script.onreadystatechange = null;
                    //callback();
                }
            };
        } else {  //Others
            script.onload = function () {
                //callback();
            };
        }
       
            script.href = url;
       
    }

    document.getElementsByTagName("head")[0].appendChild(script);
}
loadScript("https://app.helloleads.io/js/inspinia-js/jquery-2.1.1.js", "js","jquery.js"); 
//loadScript("https://app.helloleads.io/css/inspinia/bootstrap.css", "css","bootstrap.css"); 
//loadScript("https://app.helloleads.io/js/inspinia-js/bootstrap.min.js", "js","bootstrap.min.js"); 
loadScript("https://app.helloleads.io/css/sweetalert.css", "css","sweetalert.css");
loadScript("https://app.helloleads.io/js/sweetalert.min.js", "js","sweetalert.min.js");
loadScript("https://app.helloleads.io/js/webforms/form.js","js","form.js");


