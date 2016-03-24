/**
 * 
 */

function PreviewImage(obj, imgPreviewId, divPreviewId,width,height) {
   
	console.log('preview image start...');
    var allowExtention = ".jpg,.bmp,.gif,.png"; //,允许上传文件的后缀名
    var extention = obj.value.substring(obj.value.lastIndexOf(".") + 1).toLowerCase();
    var browserVersion = window.navigator.userAgent.toUpperCase();
    if (allowExtention.indexOf(extention) > -1) {
        if (browserVersion.indexOf("MSIE") > -1) {
            if (browserVersion.indexOf("MSIE 6.0") > -1) {//ie6
                document.getElementById(imgPreviewId).setAttribute("src", obj.value);
            } else {//ie[7-8]、ie9
                obj.select();
                var newPreview = document.getElementById(divPreviewId + "New");
                if (newPreview == null) {
                    newPreview = document.createElement("div");
                    newPreview.setAttribute("id", divPreviewId + "New");
                    //newPreview.style.width = width;
                    //newPreview.style.height = height;
                    newPreview.style.border = "solid 1px #d2e2e2";
                }
                newPreview.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale',src='" + document.selection.createRange().text + "')";
                var tempDivPreview = document.getElementById(divPreviewId);
                tempDivPreview.parentNode.insertBefore(newPreview, tempDivPreview);
                tempDivPreview.style.display = "none";
            }
        } else if (browserVersion.indexOf("FIREFOX") > -1) {//firefox
            var firefoxVersion = parseFloat(browserVersion.toLowerCase().match(/firefox\/([\d.]+)/)[1]);
            if (firefoxVersion < 7) {//firefox7以下版本
                document.getElementById(imgPreviewId).setAttribute("src", obj.files[0].getAsDataURL());
            } else {//firefox7.0+                    
                document.getElementById(imgPreviewId).setAttribute("src", window.URL.createObjectURL(obj.files[0]));
            }
        } else if (obj.files) {
            //兼容chrome、火狐等，HTML5获取路径                   
            if (typeof FileReader !== "undefined") {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(imgPreviewId).setAttribute("src", e.target.result);
                }
                reader.readAsDataURL(obj.files[0]);
            } else if (browserVersion.indexOf("SAFARI") > -1) {
                alert("暂时不支持Safari浏览器!");
            }
        } else {
            document.getElementById(divPreviewId).setAttribute("src", obj.value);
        }
    } else {
        alert("仅支持" + allowSuffix + "为后缀名的文件!");
        obj.value = ""; //清空选中文件
        if (browserVersion.indexOf("MSIE") > -1) {
            obj.select();
            document.selection.clear();
        }
        obj.outerHTML = obj.outerHTML;
    }
    console.log('preview image end...');
}