$(document).ready(function(){
    
    var ObjectTable;
    var DataTable = {}

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
            async: false,
            success: function(data){
                if(isJson(data)){
                    DataTable = JSON.parse(data);
                    updateTable();
                }
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
                    "searchable": false,
                    "data": "Accion",
                    "render": function( data, type, row ) {
                        switch(data){
                            case "ANSWERED":
                                return "CONTESTADA";
                            break;
                            case "NO ANSWER":
                                return "NO CONTESTADA";
                            break;
                            default:
                            break;
                        }
                    }
                },
            ]
        });
    }
});