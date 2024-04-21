var Clipboard = Quill.import('modules/clipboard');
var Delta = Quill.import('delta');
var audioUpload = false;
var videoUpload = true;
var sourcevideo = "";
var valueofImage = false;
var valueofVideo = false;
var valueofAudio = false;

class PlainClipboard extends Clipboard {
    convert(html = null) {
        if (typeof html === 'string') {
            this.container.innerHTML = html;
        }
        let text = this.container.innerText;
        this.container.innerHTML = '';
        return new Delta().insert(text);
    }
}


function displayVideo(source) {
    sourcevideo = source;
    var editorContent = editor.root.innerHTML;
    index = editorContent.indexOf("#video#");
    if (index !== -1) {
        var replacement = "<center><video id=\"local_video\" width=\"640\" height=\"480\" controls>\n<source src=\"" + source + "\" \ntype=\"video/mp4\">Sorry, your browser doesn't support the video element.</video></center>";
        editorContent = editorContent.substring(0, index) + replacement + editorContent.substring(index + 7);
        var element = document.getElementById("article_content")
        element.innerHTML = editorContent;
    }
}

function toggle() {
    var switchStatus = false;
    //$("#toggle").on('change', function() {
    if (document.getElementById("toggle").checked) {
        switchStatus = true; // $(this).is(':checked');
        $("#preview").css("z-index", "3");
        $("#preview").css("visibility", "visible");
        $("#preview").show();
        var documentContent = editor.root.innerHTML;
        console.log(documentContent);
        if (documentContent !== "<p><br></p>") {
            var element = document.getElementById("article_content")
            element.innerHTML = documentContent;

            var videoFileInput = document.getElementById("videoInput");
            if (videoFileInput.files.length > 0) {
                index = documentContent.indexOf("&lt;video&gt;");
                if (index !== -1) {
                    console.log(index);
                    var selectedFile = videoFileInput.files[0];
                    replacement = "<center><video id=\"local_video\" width=\"640\" height=\"480\" controls>\n<source src=\"" + URL.createObjectURL(selectedFile) + "\" \ntype=\"video/mp4\">Sorry, your browser doesn't support the video element.</video></center>";
                    var documentContent = documentContent.substring(0, index) + replacement + documentContent.substring(index + 13);
                    console.log(documentContent);
                    var element = document.getElementById("article_content")
                    element.innerHTML = documentContent;
                }
            }
            if (sourcevideo !== "") {
                displayVideo(sourcevideo);
            }
            //get Title
            var firstH1 = element.querySelector('h1');
            if (firstH1) {
                var title = document.getElementById("main_article_title");
                title.innerHTML = firstH1.innerHTML;
                if(firstH1.nextElementSibling){
                    if(firstH1.nextElementSibling.tagName == 'H1')
                    {
                        title.innerHTML += '<br>' + firstH1.nextElementSibling.innerHTML;
                        firstH1.nextElementSibling.remove();
                    }
                }
                firstH1.remove();

            }
            //get main Image
            var img = document.getElementById("main_image_article");
            var imginput = document.getElementById("imageInput");
            if (imginput.files.length > 0) {
                img.setAttribute("src", URL.createObjectURL(imginput.files[0]));
                $("#main_image_article").show();
            }
            var video = document.querySelectorAll("iframe");
            for (var i = video.length - 1; i >= 0; i--) {
                video[i].setAttribute("width", "560px");
                video[i].setAttribute("height", "315px");
            }

            var audioFileInput = document.getElementById("audioInput");
            if (audioFileInput.files.length > 0) {
                var selectedFile = audioFileInput.files[0];
                console.log(selectedFile);
                wavesurfer.load(URL.createObjectURL(selectedFile));
                $("#waveform").show();
                audioUpload = true;
            } else {

            }
        }
    } else {
        switchStatus = $(this).is(':checked');
        $("#preview").css("z-index", "0");
        $("#preview").hide();
    }
    //});
}

function savefile(flag, id = null) {
    document.getElementById("toggle").checked = true;
    toggle();
    var element = document.getElementById("article_content")
    var title = document.getElementById("main_article_title");
    if (editor.root.innerHTML !== "<p><br></p>") {
        console.log("toggle");
        document.getElementById('title_input').value = title.innerHTML;
        document.getElementById('content_input').value = element.innerHTML;
    }
    if (flag) {
        document.getElementById('article_id').value = id;
    }
}

Quill.register('modules/clipboard', PlainClipboard, true);

var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'], // toggled buttons
    ['blockquote', 'code-block'],

    [{
        'header': 1
    }, {
        'header': 2
    }], // custom button values
    [{
        'list': 'ordered'
    }, {
        'list': 'bullet'
    }],
    [{
        'script': 'sub'
    }, {
        'script': 'super'
    }], // superscript/subscript
    [{
        'indent': '-1'
    }, {
        'indent': '+1'
    }], // outdent/indent
    [{
        'direction': 'rtl'
    }], // text direction

    [{
        'size': ['small', false, 'large', 'huge']
    }], // custom dropdown
    [{
        'header': [1, 2, 3, 4, 5, 6, false]
    }],

    [{
        'color': []
    }, {
        'background': []
    }], // dropdown with defaults from theme
    [{
        'font': []
    }],
    [{
        'align': []
    }],

    ['link', 'video'], // Link, Image, and Video

    ['clean'] // remove formatting button
];


var options = {
    debug: 'info',
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow',
    placeholder: 'Welcome to Channel 7 editor...\n First H1 is the main title \n image upload will be place as main image \n place the mark <video> to insert uploaded video in article\nor use the input video url in the toolbar\nuse the audio input to insert record in the article.\n All file input will be visible after writing a content.',
    readOnly: false,
};


var editor = new Quill('#editor', options);

document.addEventListener("DOMContentLoaded", function() {
    var dropdownItems = document.querySelectorAll(".dropdown-item");
    var tag_category = document.getElementById("tag_category");
    var tag = document.getElementById("cat_tag");
    dropdownItems.forEach(function(item) {
        item.addEventListener("click", function() {
            var clickedValue = item.textContent;
            console.log("Clicked value:", clickedValue);
            id = ".sub" + item.id;
            $(id).css("visibility", "visible");
            tag_category.style.height = "4rem";
            tag_category.classList.add("mb-3");
            var htmlcode = "<button id=\"button"+ item.id +"\"value =\"" + clickedValue + "\" class=\"ms-2 mt-1 mb-1 border btn btn-light shadow rounded-pill\">" + clickedValue + "</button>";
            tag_category.innerHTML += htmlcode;
            item.classList.add("disabled");
            var tag = document.getElementById("cat_tag");
            if (tag.innerHTML === 'Tag(s):') {
                tag.innerHTML += "  " + clickedValue;
            } else {
                tag.innerHTML += ", " + clickedValue;
            }
            document.getElementById("category_input").value = tag.innerHTML;
            console.log(document.getElementById("category_input").value);
        });
    });

    tag_category.addEventListener("click", function(event) {
        var clickedElement = event.target;
        console.log("Clicked element:", clickedElement.value);
        dropdownItems.forEach(function(item) {
            if (item.textContent === clickedElement.value) {
                item.classList.remove("disabled");
                id = ".sub" + item.id;
                console.log(id);
                $(id).css("visibility", "hidden");
                index = tag.innerHTML.indexOf(item.textContent);
                tag.innerHTML = tag.innerHTML.substring(0, index - 2) + tag.innerHTML.substring(index + item.textContent.length)
                document.getElementById("category_input").value = tag.innerHTML;
                console.log(document.getElementById("category_input").value);
            }
        });
        clickedElement.remove();
        if (tag_category.innerHTML === "") {
            tag_category.style.height = "0rem";
        }
    });

    var videoFileInput = document.getElementById("videoInput");
    var imageFileInput = document.getElementById("imageInput");
    var audioFileInput = document.getElementById("audioInput");


    imageFileInput.addEventListener('change', function(event) {
        var container = document.getElementById("media_pile");
        var htmlcode = "<button id = \" click_remove_image \" class=\"ms-2 mt-1 mb-1 border btn btn-light shadow rounded-pill\"><i class=\"bi text-danger bi-x\">Remove Image </i></button>";
        if (valueofImage === false) {
            container.innerHTML += htmlcode;
            valueofImage = true;
            $("#main_image_article").show();
        }
    });
    audioFileInput.addEventListener('change', function(event) {
        var container = document.getElementById("media_pile");
        var htmlcode = "<button id = \" click_remove_audio \"  class=\"ms-2 mt-1 mb-1 border btn btn-light shadow rounded-pill\"><i class=\"bi text-danger bi-x\">Remove Audio </i></button>";
        if (valueofAudio === false) {
            container.innerHTML += htmlcode;
            valueofAudio = true;
            $("#waveform").show();
        }
    });
    videoFileInput.addEventListener('change', function(event) {
        var container = document.getElementById("media_pile");
        var htmlcode = "<button id = \" click_remove_video \" class=\"ms-2 mt-1 mb-1 border btn btn-light shadow rounded-pill\"><i class=\"bi text-danger bi-x\">Remove Video </i></button>";
        if (valueofVideo === false) {
            container.innerHTML += htmlcode;
            valueofVideo = true;
        }
    });

    var container = document.getElementById("media_pile");
    container.addEventListener("click", function(event) {
        var clickedElement = event.target;
        if (clickedElement.innerHTML == "<i class=\"bi text-danger bi-x\">Remove Image </i>") {
            clickedElement.remove();
            imageFileInput.value = "";
            valueofImage = false;
            $("#main_image_article").hide();
            var checkimg = document.getElementById("remove_image");
            if (checkimg) {
                checkimg.checked = true;
                console.log(checkimg.checked);
            }
        } else if (clickedElement.innerHTML == "<i class=\"bi text-danger bi-x\">Remove Video </i>") {
            clickedElement.remove();
            videoFileInput.value = "";
            valueofVideo = false;
            var checkvideo = document.getElementById("remove_video");
            if (checkvideo) {
                checkvideo.checked = true;
                console.log(checkvideo.checked);
            }
        } else if (clickedElement.innerHTML == "<i class=\"bi text-danger bi-x\">Remove Audio </i>") {
            clickedElement.remove();
            audioFileInput.value = "";
            valueofAudio = false;
            wavesurfer.load(null);
            $("#waveform").hide();
            var checkaudio = document.getElementById("remove_audio");
            if (checkaudio) {
                checkvideo.checked = true;
                console.log(checkvideo.checked);
            }
        }
    });
});



const uploadButtons = document.querySelectorAll('.q1_image');

uploadButtons.forEach((button, index) => {
    button.addEventListener('click', function() {
        document.getElementById("image_input").click();
    });
});
