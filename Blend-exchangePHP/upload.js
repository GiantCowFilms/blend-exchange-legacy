var blendDropzone = new Dropzone("#uploadTarget",
    {
        url: "/finish/",
        clickable: ["#uploadTarget", ".centerText", "#uploadText"],
        maxFilesize: 30,
        autoProcessQueue: false,
        acceptedFiles: ".blend",
        uploadMultiple: false,
        previewTemplate: '<div><div><h2 data-dz-name>Name.blend</h2><div class="progressContainer"  role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" ><div class="progress"style="width:0%;" data-dz-uploadprogress></div></div><span data-dz-size>- 3.5MB</span></div><div>Files may take some time to process</div><div data-dz-errormessage class="nwDanger"></div></div>', previewsContainer: "#uploadArea", maxFiles: 1
    });
blendDropzone.on("addedfile", function () {
    $("#uploadText").hide();
});
blendDropzone.on("maxfilesexceeded", function (file) {
    this.removeAllFiles();
    this.addFile(file);
});
blendDropzone.on("error", function (file) {
    alert(["error uploading"]);
});
$(".centerText").click(function (e) {
    e.stopPropagation();
});
$("#uploadText").click(function (e) {
    e.stopPropagation();
});
blendDropzone.on("success", function (file, r) {
    try {
        var result = jQuery.parseJSON(r);        
    } catch (e) {
        var result = {status: 1};
    }
    if (result.status !== 1) {
        blendDropzone.removeFile(file);
        file.status = undefined;
        file.accepted = undefined;
        blendDropzone.addFile(file);
        showError(result.message, $("#" + result.field));
    } else { 
        //Alert for iframe
        window.parent.postMessage({ name: 'uploadAct' }, "*");
        //Alert for popup
        if (window.opener != null && !window.opener.closed) {
            window.opener.postMessage({name: 'uploadAct'}, "*");
        }
        document.write(r);
    }
});

var errorElementTimeout;

function showError(text, elm) {
    var uploadText = $("#uploadUrlError").html();

    $("#uploadUrlError").html(text);

    $("#uploadUrlError").insertBefore(elm);

    $(elm).removeClass("txtBlueError")
    //Delay is needed for reset due to a "bug?"
    setTimeout(function () { $(elm).addClass("txtBlueError") }, 10);

    $("#uploadUrlError").show();
    clearTimeout(errorElementTimeout);
    errorElementTimeout = setTimeout(function () {
        $("#uploadUrlError").hide();
    }, 8000);
}

$("#upload").click(function () {
    var formData = [];
    $('#mainContainer input').each(function () {
        if ($(this).is(':checkbox')) {
            var value = $(this).is(":checked");
        } else {
            var value = $(this).val();
        }
        var name = $(this).attr('id');
        formData.push({
            name: name,
            value: value
        });
    });

    var password = '';
    var questionUrl = $("#questionUrl").val().trim();

    var consent_params = "";
    formData.forEach(function (value,index) {
        consent_params += `&${value.name}=${value.value}`;
    })
    //Better Regex (WIP): /^^https?:\/\/blender.stackexchange.com\/q(?:uestions|)\/[0-9]+\/(?:[A-z\-#0-9\/_?=]+|[0-9]+)?$/g
    $.ajax({
        url: "/finish/verifyUrl",
        type: "get",
        success: function (result) {
            result = jQuery.parseJSON(result);
            if (result.status == 1) {
                blendDropzone.options.url = "/finish/?url=" + encodeURIComponent(questionUrl) + "&password=" + password + consent_params;
                blendDropzone.processQueue();
            } else {
                showError(result.message, $("#" + result.field));
            }
        },
        data: { url: questionUrl }
    });
    if (/^https?:\/\/blender.stackexchange.com\/q(?:uestions)?\/[0-9]+\/(?:[A-z\-#0-9\/_?=&]+|[0-9]+)?$/.test(questionUrl)) {
        blendDropzone.options.url = "/finish/?url=" + encodeURIComponent(questionUrl) + "&password=" + password + consent_params;
        blendDropzone.processQueue();
    } else {
        var errorText = 'The provided url is not valid, please copy and paste the <b>entire</b> url, including the "https://" header.';
        if (/^https?:\/\/blender.stackexchange.com\/a(?:nswer)?\/[0-9]+\/[0-9]+$/.test(questionUrl)) {
            errorText = $("#uploadUrlError").html("Please use the <b>Question Url, not the Answer Url.</b> We cannot correctly process Answer Urls because of technical difficulties.");
        }

        showError(errorText, $("#questionUrl"));
        return;
    }
});
$("#cancel").click(function () {
    blendDropzone.removeAllFiles(true);
});