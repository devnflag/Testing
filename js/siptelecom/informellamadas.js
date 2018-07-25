$(document).ready(function(){
    
    var ObjectTable;
    var DataTable = {}

    getLastSixMonths();
    updateTable();

    $("select[name='Periodo']").change(function(){
        var Periodo = $(this).val();
        getData(Periodo);
    });

    function getData(Periodo){
        $.ajax({
            type: "POST",
            url: "../includes/siptelecom/getInformeLlamadas.php",
            data: { 
                Periodo: Periodo
            },
            beforeSend: function(){
				$(".page-loader").addClass("ActiveLoader");
            },
            //async: false,
            success: function(data){
                $(".page-loader").removeClass("ActiveLoader");
                if(isJson(data)){
                    DataTable = JSON.parse(data);
                    updateTable();
                }
            },
            error: function(){
            }
        });
    }
    function getLastSixMonths(){
        $.ajax({
            type: "POST",
            url: "../includes/siptelecom/getLastSixMonths.php",
            data: {},
            success: function(data){
                console.log(data);
                $("select[name='Periodo']").html(data);
                //$("select[name='Periodo']").select2();
            },
            error: function(){
            }
        });
    }
    function updateTable(){
        ObjectTable = $('#dt_informeLlamadas').DataTable({
            "bDestroy": true,
            autoWidth: false,
            responsive: true,
            language: {
                searchPlaceholder: "Buscar..."
            },
            columns: [
                { data: 'FechaHora' },
                { data: 'NumeroDestino' },
                { data: 'Duraccion' },
                { data: 'Accion' },
            ],
            data: DataTable,
            "columnDefs": [
                {
                    "targets": 3,
                    "render": function( data, type, row ) {
                        switch(data){
                            case "ANSWERED":
                                return "CONTESTADA";
                            break;
                            case "NO ANSWER":
                                return "NO CONTESTADA";
                            break;
                            default:
                                return "ERROR"
                            break;
                        }
                    }
                },
            ]
        });
    }
});