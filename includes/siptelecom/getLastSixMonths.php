<?php
    $FinalDate = date("Ymd");
    $FromDate = date("d-m-Y",strtotime($FinalDate."- 5 months"));
    for($i=1; $i<=6; $i++){
        echo date("m",strtotime($FromDate));
        $FromDate = date("d-m-Y",strtotime($FromDate."+ 1 months"));
    }
?>