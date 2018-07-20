<?php
    $FinalDate = date("Ymd");
    $FromDate = date("d-m-Y",strtotime($FinalDate."- 5 months"));
    $ToReturn = "<option value=''>Seleccione</option>";
    for($i=1; $i<=6; $i++){
        $Month = date("m",strtotime($FromDate));
        $Year = date("Y",strtotime($FromDate));
        $ToReturn .= "<option value='".$Month."/".$Year."'>".getMonthName($Month)." ".$Year."</option>";
        $FromDate = date("d-m-Y",strtotime($FromDate."+ 1 months"));
    }
    echo $ToReturn;

    function getMonthName($Month){
        $Months = array();
        $Months["01"] = "ENERO";
        $Months["02"] = "FEBRERO";
        $Months["03"] = "MARZO";
        $Months["04"] = "ABRIL";
        $Months["05"] = "MAYO";
        $Months["06"] = "JUNIO";
        $Months["07"] = "JULIO";
        $Months["08"] = "AGOSTO";
        $Months["09"] = "SEPTIEMBRE";
        $Months["10"] = "OCTUBRE";
        $Months["11"] = "NOVIEMBRE";
        $Months["12"] = "DICIEMBRE";
        return $Months[$Month];
    }
?>