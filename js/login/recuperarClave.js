$(document).ready(function(){

    $("button[name='btnRecuperar']").click(function(){
        var Mail = $("input[name='Mail']").val();
        Recuperar(Mail);
    });

    function Recuperar(Mail){
        $.ajax({
            type: "POST",
            url: "../includes/login/recuperarContrasena.php",
            data: { 
                Mail: Mail
            },
            beforeSend: function(){
				$(".page-loader").addClass("ActiveLoader");
            },
            //async: false,
            success: function(data){
                $(".page-loader").removeClass("ActiveLoader");
                var Json = JSON.parse(data);
                if(Json.result){
                    swal({
                        title: '¡Bienvenido!',
                        text: 'Ha recuperado su contraseña satisfactoriamente.',
                        type: 'success',
                        timer: 2000,
                        buttonsStyling: false,
                        showConfirmButton: false,
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-sm btn-light',
                        background: 'rgba(0, 0, 0, 0.96)'
                    }).then(function(){
                        window.location = "../index.php";
                    });
                }else{
                    swal({
                        title: '¡Error!',
                        text: Json.Message,
                        type: 'warning',
                        timer: 2000,
                        buttonsStyling: false,
                        showConfirmButton: false,
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-sm btn-light',
                        background: 'rgba(0, 0, 0, 0.96)'
                    });
                }
            },
            error: function(){
            }
        });
    }
});