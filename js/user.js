function login(){
    var username = $('#username').val();
    var password = $('#password').val();

    $btn = $('#btn-submit');
    $btn.addClass('-loading');
    $btn.html('กำลังเข้าระบบ...');
    $('#login-loading').fadeIn(300);
    $('#login-loading').animate({width:'70%'},500);

    $.ajax({
        url         :'api.user.php',
        cache       :false,
        dataType    :"json",
        type        :"POST",
        data:{
            action      :'login',
            username    :username,
            password    :password,
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    }).done(function(data){
        console.log(data);

        if(data.return == 1){
            $('#login-loading').animate({width:'100%'},300);
            setTimeout(function(){
                window.location = 'index.php?login=success';
            },1000);
        }else if(data.return == 0){
            $('#login-loading').animate({width:'0%'},100);
            $('#login-loading').fadeOut(100);
            alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!');
            $('#password').val('');

            $btn.removeClass('-loading');
            $btn.html('เข้าระบบ');
            $('#username').focus();
        }
    });
}

function changePassword(){
    var oldpassword = $('#oldpassword').val();
    var password    = $('#password').val();
    var repassword  = $('#repassword').val();

    if(oldpassword == ''){
        alert('กรุณากรอกรหัสผ่านเดิม!');
        $('#oldpassword').focus();
        return false;
    }
    else if(password == '') return false;
    else if(password != repassword){
        $('#password').val('');
        $('#repassword').val('');
        $('#password').focus();
        alert('รหัสผ่านใหม่ของคุณไม่ตรงกัน!');
        return false;
    }

    $btn = $('#btn-submit');
    $btn.addClass('-loading');
    $btn.html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>กำลังเปลี่ยนรหัสผ่านใหม่...');

    $.ajax({
        url         :'api.user.php',
        cache       :false,
        dataType    :"json",
        type        :"POST",
        data:{
            action      :'change_password',
            oldpassword :oldpassword,
            password    :password,
        },
        error: function (request, status, error){
            console.log("Request Error");
        }
    }).done(function(data){
        console.log(data);

        setTimeout(function(){
            window.location = 'logout.php?';
        },1000);
    });
}