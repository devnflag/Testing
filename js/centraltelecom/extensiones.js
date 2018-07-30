$(document).ready(function(){

    $("button[name='new']").click(function(){
        var nombreExtension = $("input[name='nombreExtension']").val();
        newExtension(nombreExtension);
    });
    $(".Update").click(function(e){
        e.preventDefault();
    });
    $(".Delete").click(function(e){
        e.preventDefault();
    });

    function newExtension(nombreExtension){
        $.ajax({
            type: "POST",
            url: "../includes/centraltelecom/newExtension.php",
            data: { 
                nombreExtension: nombreExtension
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
                    if(Json.result){
                        $("input[name='nombreExtension']").val("");
                        $("#newExtension").modal('toggle');
                        swal({
                            title: '¡Extensión creada!',
                            text: 'La Extension: '+nombreExtension+' Fue creada satisfactoriamente',
                            type: 'success',
                            buttonsStyling: false,
                            showConfirmButton: true,
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-sm btn-light',
                            background: 'rgba(0, 0, 0, 0.96)'
                        }).then(function(){
                            location.reload();
                        });
                    }
                }
            },
            error: function(){
            }
        });
    }
});