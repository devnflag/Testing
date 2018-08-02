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
});