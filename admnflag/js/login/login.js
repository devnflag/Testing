$(document).ready(function(){

    $("button[name='btnLogin']").click(function(){
        var User = $("input[name='User']").val();
        var Password = $("input[name='Password']").val();
        Login(User,Password);
    });


    function Login(User,Password){
        $.ajax({
            type: "POST",
            url: "../admnflag/includes/login/getUserMatch.php",
            data: { 
                User: User,
                Password: Password
            },
            async: false,
            success: function(data){
                var Json = JSON.parse(data);
                if(Json.result){
                    swal({
                        title: '¡Bienvenido!',
                        text: 'Ha iniciado sesion satisfactoriamente.',
                        type: 'success',
                        timer: 2000,
                        buttonsStyling: false,
                        showConfirmButton: false,
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-sm btn-light',
                        background: 'rgba(0, 0, 0, 0.96)'
                    }).then(function(){
                        location.reload();
                    });
                }else{
                    swal({
                        title: '¡Error!',
                        text: 'Usuario o Contraseña incorrecta.',
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