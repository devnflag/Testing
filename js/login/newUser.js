$(document).ready(function(){

    $("input[name='mail'],input[name='remail']").keyup(function(){
        var Mail = $("input[name='mail']").val();
        var ReMail = $("input[name='remail']").val();
        if(Mail == ReMail){
            $("input[name='mail']").removeClass("is-invalid");
            $("input[name='remail']").removeClass("is-invalid");
            
            $("input[name='mail']").addClass("is-valid");
            $("input[name='remail']").addClass("is-valid");
        }else{
            $("input[name='mail']").removeClass("is-valid");
            $("input[name='remail']").removeClass("is-valid");

            $("input[name='mail']").addClass("is-invalid");
            $("input[name='remail']").addClass("is-invalid");
        }
    });
    $("button[name='ok']").click(function(){
        var FullName = $("input[name='name']").val();
        var DNI = $("input[name='dni']").val();
        var Mail = $("input[name='mail']").val();
        var ReMail = $("input[name='remail']").val();
        var Address = $("textarea[name='address']").val();
        var CanAdd = false;
        if(Mail == ReMail){
            if(FullName != ""){
                if(DNI != ""){
                    if(Mail != ""){
                        if(Address != ""){
                            CanAdd = true;
                        }
                    }
                }
            }
            if(CanAdd){
                addClient();
            }else{
                swal({
                    title: '¡Error!',
                    text: 'Debe llenar todos los datos.',
                    type: 'warning',
                    buttonsStyling: false,
                    showConfirmButton: false,
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-sm btn-light',
                    background: 'rgba(0, 0, 0, 0.96)'
                });
            }
        }
    });
    $("button[name='cancel']").click(function(){
        window.location = "../index.php";
    });

    function addClient(){
        var FullName = $("input[name='name']").val();
        var DNI = $("input[name='dni']").val();
        var Mail = $("input[name='mail']").val();
        var ReMail = $("input[name='remail']").val();
        var Address = $("textarea[name='address']").val();
        
        $.ajax({
            type: "POST",
            url: "../includes/login/newUser.php",
            data: {
                FullName: FullName,
                DNI: DNI,
                Mail: Mail,
                Address: Address,
            },
            beforeSend: function(){
				$(".page-loader").addClass("ActiveLoader");
            },
            //async: false,
            success: function(data){
                $(".page-loader").removeClass("ActiveLoader");
                console.log(data);
                if(isJson(data)){
                    var Json = JSON.parse(data);
                    console.log(Json);
                    if(Json.result){
                        swal({
                            title: '¡Felicidades!',
                            text: 'Su cuenta ha sido registrada correctamente.',
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
                        if(Json.FailMail){
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
                        }else{
                            swal({
                                title: '¡Error!',
                                text: 'Hubo un problema para crear la cuenta, comuniquese con soporte.',
                                type: 'warning',
                                timer: 2000,
                                buttonsStyling: false,
                                showConfirmButton: false,
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-sm btn-light',
                                background: 'rgba(0, 0, 0, 0.96)'
                            });
                        }
                    }
                }
            },
            error: function(){
            }
        });
    }
});