$(document).ready(function(){

    $(".select_plan").click(function(){
        var ID = $(this).attr("id");
        var IDArray = ID.split("_");
        var idPlan = IDArray[1];
        var Precio = IDArray[0];
        swal({
            title: '¿Esta seguro de contratar la bolsa seleccionada?',
            text: 'Se le hara un recargo a su cuenta de ' + Precio,
            type: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-success',
            confirmButtonText: 'Aceptar',
            cancelButtonClass: 'btn btn-light',
            cancelButtonText: 'Cancelar',
            background: 'rgba(0, 0, 0, 0.96)'
        }).then(function(data){
            if(data.value){
                contratarPlan(idPlan);
            }
        });
    });

    function contratarPlan(idPlan){
        $.ajax({
            type: "POST",
            url: "../includes/siptelecom/contratarPlan.php",
            data: { 
                idPlan: idPlan
            },
            async: false,
            success: function(data){
                if(isJson(data)){
                    var Json = JSON.parse(data);
                    if(Json.result){
                        swal({
                            title: '¡Plan Contratado!',
                            text: 'Ha contratado el plan "' + Json.Plan + '" el cual cuenta con ' + Json.Minutos + ' minutos y vencen en ' + Json.TiempoVencimiento,
                            type: 'success',
                            buttonsStyling: false,
                            showConfirmButton: true,
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-sm btn-light',
                            background: 'rgba(0, 0, 0, 0.96)'
                        });
                    }else{
                        swal({
                            title: '¡Error!',
                            text: Json.Message,
                            type: 'warning',
                            buttonsStyling: false,
                            showConfirmButton: true,
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
});