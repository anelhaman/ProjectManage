$(document).ready(function(){
    pdfGenerate();
});

function pdfGenerate(){

    var month = $('#cmonth').val();
    var year = $('#cyear').val();

    $('#progress-bar').fadeIn(300);
    $('#progress-bar').animate({width:'70%'},500);

    $.ajax({
        url         :'pdf.php',
        cache       :false,
        dataType    :"json",
        type        :"GET",
        data:{
            month    :month,
            year    :year,
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    }).done(function(data){
        console.log(data);

        $('#progress-bar').animate({width:'100%'},500);
        $('#progress-bar').fadeOut(300);

        if(data.return == 'success' || data.return == 'already'){
            $('#btn-print').addClass('-active');
            $('#btn-print').html('ครึ่งหน้า');

            $('#btn-print-fullpage').addClass('-active');
            $('#btn-print-fullpage').html('เต็มหน้า');
        }
    });
}