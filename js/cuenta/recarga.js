$(document).ready(function(){
    var myDropzone;
    
	$("#dropzoneComprobantes").dropzone({
		url: "../includes/comprobantes/cargaComprobante.php",
		acceptedFiles: ".jpg,.png,.jpeg",
		maxFiles:1,
		uploadMultiple: false, // Adding This 
        parallelUploads: 1,
        maxFilesize: 10,
		autoProcessQueue: false,
		init: function() {
			myDropzone = this;
		},

		sending: function(file, xhr, formData) {
            formData.append("idServicio", "2");
            formData.append("tipoComprobante",$("select[name='tipoComprobante']").val());
		},

		error: function(file,response){
			console.log(response);
			if(response == "You can't upload files of this type."){
				swal({
                    title: '¡Error!',
                    text: "El archivo debe ser de tipo '.jpg', '.jpeg' o '.png'",
                    type: 'warning',
                    buttonsStyling: false,
                    showConfirmButton: true,
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-sm btn-light',
                    background: 'rgba(0, 0, 0, 0.96)'
                });
			}
			myDropzone.removeAllFiles();
		},

		success: function (file, response) {
            if(isJson(response)){
                var Json = JSON.parse(response);
                if(Json.result){
                    swal({
                        title: '¡Pago registrado!',
                        text: "Su pago ha sido registrado, en unos minutos le enviaremos un correo avisando la confirmación de recarga. Le recordamos que nuestro horario de aprobación de recargas es de 8am a 8pm.",
                        type: 'success',
                        buttonsStyling: false,
                        showConfirmButton: true,
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-sm btn-light',
                        background: 'rgba(0, 0, 0, 0.96)'
                    });
                }else{
                    swal({
                        title: '¡Eror!',
                        text: Json.Message,
                        type: 'danger',
                        buttonsStyling: false,
                        showConfirmButton: true,
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-sm btn-light',
                        background: 'rgba(0, 0, 0, 0.96)'
                    });
                }
            }
			myDropzone.removeAllFiles();
		},
		processing: function () {
			$('#load').modal({
				backdrop: 'static',
				keyboard: false
			})
		}
    });
    
    $("button[name='Registrar']").click(function(){
        var tipoComprobante = $("select[name='tipoComprobante']").val();
        if(tipoComprobante != ""){
            myDropzone.processQueue();
        }else{
            swal({
                title: '¡Eror!',
                text: "Debe seleccionar un tipo metodo de pago.",
                type: 'warning',
                buttonsStyling: false,
                showConfirmButton: true,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-sm btn-light',
                background: 'rgba(0, 0, 0, 0.96)'
            });
        }
    });
    $("input[name='pesosChile']").keyup(function(){
        var Pesos = $(this).val();
        if(Pesos == ""){
            Pesos = 0;
        }
        var Tasa = $("#tasaDolar").html();
        var ComisionPaypal2 = $("#comisionPaypal2").html();
        Tasa = Number(Tasa.replace("$ ",""));
        ComisionPaypal2 = Number(ComisionPaypal2.replace(" $",""));
        var Dolares = (Pesos / Tasa);
        var ComisionPaypal1 = Dolares > 0 ? (Dolares * 0.029) + 0.3 : 0;
        var Total = Dolares > 0 ? (Dolares + ComisionPaypal1 + ComisionPaypal2).toFixed(2) : 0;
        ComisionPaypal1 = ComisionPaypal1.toFixed(2);
        Dolares = Dolares.toFixed(2);
        $("#comisionPaypal1").html(ComisionPaypal1+" $");
        $("#Dolares").html(Dolares+" $");
        $("#totalDolares").html(Total+" $");
    });
    $("input[name='pesosChile']").on("input", function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
    });
    $("button[name='pagarPaypal']").click(function(){
        var Pesos = $("input[name='pesosChile']").val();
        if(Pesos == ""){
            Pesos = 0;
        }
        var Tasa = $("#tasaDolar").html();
        var ComisionPaypal2 = $("#comisionPaypal2").html();
        Tasa = Number(Tasa.replace("$ ",""));
        ComisionPaypal2 = Number(ComisionPaypal2.replace(" $",""));
        var Dolares = (Pesos / Tasa);
        var ComisionPaypal1 = Dolares > 0 ? (Dolares * 0.029) + 0.3 : 0;
        var Total = Dolares > 0 ? (Dolares + ComisionPaypal1 + ComisionPaypal2).toFixed(2) : 0;
        ComisionPaypal1 = ComisionPaypal1.toFixed(2);
        Dolares = Dolares.toFixed(2);
        $("#comisionPaypal1").html(ComisionPaypal1+" $");
        $("#Dolares").html(Dolares+" $");
        $("#totalDolares").html(Total+" $");
        if(Total > 0){
            PagarPaypal(Pesos);
        }else{
            swal({
                title: '¡Error!',
                text: 'Debe ingresar una cantidad de pesos a comprar.',
                type: 'warning',
                timer: 2000,
                buttonsStyling: false,
                showConfirmButton: false,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-sm btn-light',
                background: 'rgba(0, 0, 0, 0.96)'
            });
        }
    });

    function PagarPaypal(Pesos){
        window.location = "../cuenta/Paypal.php?saldo="+Pesos;
    }
});