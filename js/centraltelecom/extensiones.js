$(document).ready(function(){

    $("button[name='new']").click(function(){
        var nombreExtension = $("input[name='nombreExtension']").val();
        newExtension(nombreExtension);
    });
    $(".Update").click(function(e){
        e.preventDefault();
        var Extension = $(this).closest(".Extension").attr("id");
        $("#updateExtension").modal('show');
        $("#updateExtension").attr("ext",Extension);
    });
    $("button[name='update']").click(function(e){
        var nombreExtension = $("input[name='nombreExtension_update']").val();
        var Extension = $("#updateExtension").attr("ext");
        updateExtension(nombreExtension,Extension);
    });
    $(".Habilitacion").click(function(e){
        e.preventDefault();
        var Extension = $(this).closest(".Extension").attr("id");
        habilitacionExtension(Extension);
    });

    function newExtension(nombreExtension){
        $.ajax({
            type: "POST",
            url: "../includes/centraltelecom/newExtension.php",
            data: { 
                nombreExtension: nombreExtension,
                Extension: Extension
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
                    }else{
                        swal({
                            title: '¡Error!',
                            text: Json.Message,
                            type: 'warning',
                            buttonsStyling: false,
                            showConfirmButton: false,
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-sm btn-light',
                            background: 'rgba(0, 0, 0, 0.96)'
                        });
                    }
                }
            },
            error: function(){
            }
        });
    }
    function updateExtension(nombreExtension,Extension){
        $.ajax({
            type: "POST",
            url: "../includes/centraltelecom/updateExtension.php",
            data: { 
                nombreExtension: nombreExtension,
                Extension: Extension
            },
            beforeSend: function(){
				$(".page-loader").addClass("ActiveLoader");
            },
            //async: false,
            success: function(data){
                $("#updateExtension").modal('hide');
                $(".page-loader").removeClass("ActiveLoader");
                console.log(data);
                if(isJson(data)){
                    var Json = JSON.parse(data);
                    if(Json.result){
                        swal({
                            title: 'Extensión actualizada!',
                            text: 'La Extension: '+nombreExtension+' Fue actualizada satisfactoriamente',
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
    function habilitacionExtension(Extension){
        $.ajax({
            type: "POST",
            url: "../includes/centraltelecom/habilitacionExtension.php",
            data: { 
                Extension: Extension
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
                        swal({
                            title: 'Extensión actualizada!',
                            text: 'La Extension: '+nombreExtension+' Fue actualizada satisfactoriamente',
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