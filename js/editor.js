var article_id;
$files = $();

$(document).ready(function(){

    initialise();

    $('#editor').on('click','.image_preview',function(e){
        var content_id   = $(this).parent().attr('id');

        $files = $('#'+content_id).children('.fileinput');
        $files.focus().click();

        console.log($files,content_id);

        $files.change(function(){
            var files   = this.files;

            $thumbnail  = $('#'+content_id).children('.image_preview');
            $thumbnail.html(''); // Clear thumbnail container.

            var file    = files[0];
            var imageType = /image.*/

            if(!file.type.match(imageType)){
                console.log("Not an Image");
                // continue;
            }

            var image = document.createElement("img");

            image.file = file;
            // $thumbnail.addClass('-preupload');
            $thumbnail.append(image);

            var reader = new FileReader();

            reader.onload = (function(aImg){
                return function(e){
                    aImg.src = e.target.result;
                };
            }(image));

            var ret = reader.readAsDataURL(file);
            var canvas = document.createElement("canvas");
            ctx = canvas.getContext("2d");

            image.onload= function(){ ctx.drawImage(image,100,100); }

            $('html,body').animate({ scrollTop: $('#'+content_id).offset().top },'slow');
            $('#'+content_id).submit();
        });
    });

	$('#btn-add-text').click(function(){
		console.log('article_id',article_id);

		$.ajax({
	        url         :'api.content.php',
	        cache       :false,
	        dataType    :"json",
	        type        :"POST",
	        data:{
	            action     	:'create_content',
	            article_id 	:article_id,
	            type 		:'text',
	        },
	        error: function (request, status, error){
	        	console.log(request, status, error);
	            console.log("Request Error");
	        }
	    }).done(function(data){
	        console.log(data);
	        location.reload();
	    });
	});

	$('#btn-add-image').click(function(){

		$.ajax({
	        url         :'api.content.php',
	        cache       :false,
	        dataType    :"json",
	        type        :"POST",
	        data:{
	            action     	:'create_content',
	            article_id 	:article_id,
	            type 		:'image',
	        },
	        error: function (request, status, error){
	            console.log("Request Error");
	        }
	    }).done(function(data){
	        console.log(data);
            var content_id = data.return;
            var html = $('<div class="content-edit" id="content-'+content_id+'" data-id="'+content_id+'"><form class="image-form" id="imageform-'+content_id+'" data-id="'+content_id+'" action="upload_image.php" method="post" enctype="multipart/form-data"><div class="thumbnail_photo"><span>เลือกไฟล์รูปภาพ ('+content_id+')</span></div><div class="loading"><div class="bar"></div></div><input name="image" type="file" class="fileinput"/><input type="text" class="input-text-alt" placeholder="อธิบายภาพ..."><input type="hidden" name="content_id" value="'+content_id+'"><button type="submit">UPLOAD</button></form><div class="content-control"><button class="btn-content-remove" data-id="29">ลบ</button><button class="btn-content-up" data-id="'+content_id+'">เลื่อนขึ้น</button><button class="btn-content-down" data-id="29">เลื่อนลง</button></div></div>');

            $("#editor").append(html);

            initialise();
	    });

        // $files.focus().click();
	});
});

function initialise(){

    $('.animated').autosize({append: "\n"});
    // $bar = $('#loading-bar');
    article_id = $('#article_id').val();

    var current_form;
    $('.contentForm').ajaxForm({
        beforeSubmit: function(formData, jqForm){
            current_form = jqForm[0].id;

            $('#'+current_form+' .loading').fadeIn(100);
            $('#'+current_form+' .loading .bar').width('0%');

            // $('#btn-submit').addClass('-disable');
            // $('#btn-submit').html('กำลังบันทึก...');

            console.log('current_form',current_form);
        },
        uploadProgress: function(event,position,total,percentComplete) {
            var percent = percentComplete;

            percent = (percent * 80) / 100;
            $('#'+current_form+' .loading .bar').animate({width:percent+'%'},500);
            
            // console.log('Upload: '+percentComplete+' %');
        },
        success: function() {
            $('#'+current_form+' .loading .bar').animate({width:'100%'},300);
        },
        complete: function(xhr) {
            // console.log(xhr.responseText);
            // console.log(xhr.responseJSON);

            var image_file = xhr.responseJSON.image_file;
            console.log('image url',image_file);

            // $('#'+current_form+' .thumbnail_photo').html('<img src="image/upload/normal/'+image_file+'"/>');
            $('#'+current_form+' .loading').fadeOut(300);
        }
    });

    // CONTENT TEXT EDIT
    $('.input-textarea').blur(function(){
        var content_id  = $(this).parent().attr('data-id');
        var message     = $(this).val();

        $.ajax({
            url         :'api.content.php',
            cache       :false,
            dataType    :"json",
            type        :"POST",
            data:{
                action      :'edit_content_text',
                content_id  :content_id,
                article_id  :article_id,
                message     :message,
            },
            error: function (request, status, error){
                console.log("Request Error");
            }
        }).done(function(data){
            console.log(data.message,message);
        });
    });

    $('.input-text-alt').blur(function(){
        var content_id = $(this).parent().attr('data-id');
        var image_alt = $(this).val();

        console.log(content_id,image_alt,article_id);

        $.ajax({
            url         :'api.content.php',
            cache       :false,
            dataType    :"json",
            type        :"POST",
            data:{
                action      :'edit_image_alt',
                content_id  :content_id,
                article_id  :article_id,
                image_alt    :image_alt,
            },
            error: function (request, status, error){
                console.log("Request Error");
            }
        }).done(function(data){
            console.log(data);
        });
    });

    $('.btn-content-remove').click(function(){
        var content_id = $(this).parent().parent().attr('data-id');

        if(!confirm('คุณต้องการลบเนื้อหาส่วนนี้่ ใช่หรือไม่ ?')){ return false; }

        $.ajax({
            url         :'api.content.php',
            cache       :false,
            dataType    :"json",
            type        :"POST",
            data:{
                action      :'disable_content',
                content_id  :content_id,
                article_id  :article_id,
            },
            error: function (request, status, error){
                console.log(request, status, error);
                console.log("Request Error");
            }
        }).done(function(data){
            console.log(data);

            $('#contentForm'+content_id).remove();
        });
    });
}


// function reload(){
//             var container = document.getElementById("yourDiv");
//             var content = container.innerHTML;
//             container.innerHTML= content;
//         }