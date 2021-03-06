                <header class="content__title">
                    <h1>Servicios</h1>
                    <small>Resumen de Cuenta.</small>
                </header>
                
                <?php
                    $ClientesClass = new Clientes();
                    $ServiciosClass = new Servicios();
                    $Servicios = $ServiciosClass->getServiciosAsociados();
                    foreach($Servicios as $Servicio){
                        $idServicio = $Servicio["id"];
                        $nombreServicio = $Servicio["nombre"];
                        $descripcionServicio = $Servicio["descripcion"];
                        switch($idServicio){
                            case "2":
                                $SipTelecomClass = new SipTelecom();

                                $Saldo = number_format($ClientesClass->getSaldo($_SESSION["userID"]), 2, ',', '.');
                                $Plan = $SipTelecomClass->getPlanActivado($_SESSION["userID"],'0');
                                $PrecioMinutoUnitario = $SipTelecomClass->getPrecioPorMinutoUnitario();
                                if(count($Plan) > 0){
                                    $Plan = $Plan[0];
                                    $SegundosRestantes = $SipTelecomClass->getSegundosRestantes($_SESSION["userID"]);
                                    $MinutosRestantes = $SipTelecomClass->conversorSegundosHoras($SegundosRestantes);
                                    $SegundosUtilizados = ($Plan["cantidadMinutos"] * 60) - $SegundosRestantes;
                                    $MinutosUtilizados = $SipTelecomClass->conversorSegundosHoras($SegundosUtilizados);
                                    $NombrePlan = $Plan["nombre"];
                                    $fechaActivacion = $Plan["fechaActivacion"];
                                    $fechaCulminacion = $Plan["fechaCulminacion"];
                                    $CantidadLlamadas = $SipTelecomClass->getCallsInPeriodTime($_SESSION["userID"],$fechaActivacion,$fechaCulminacion);
                                    $fechaActivacion = date("d/m/Y",strtotime($Plan["fechaActivacion"]));
                                    $fechaCulminacion = date("d/m/Y",strtotime($Plan["fechaCulminacion"]));
                                }else{
                                    $MinutosRestantes = 0;
                                    $MinutosUtilizados = 0;
                                    $NombrePlan = " Sin plan asociado";
                                    $fechaActivacion = "-";
                                    $fechaCulminacion = "-";
                                    $CantidadLlamadas = 0;
                                }

                                ?>
                                    <div class="row">
                                        <div class="card col-sm-12">
                                            <div class="card-body">
                                                <h4 class="card-title"><?php echo $nombreServicio; ?></h4>
                                                <h6 class="card-subtitle"><?php echo $descripcionServicio; ?></h6>

                                                <div class="row" style="margin-bottom: 25px;">
                                                    <div class="col-sm-3"></div>
                                                    <div class="col-sm-6">
                                                        <div class="invoice__attrs__item">
                                                            <small>Saldo</small>
                                                            <h3>$ <?php echo $Saldo; ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="invoice__attrs__item">
                                                            <small>Precio por Minuto</small>
                                                            <h3>$ <?php echo $PrecioMinutoUnitario; ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="invoice__attrs__item">
                                                            <small>Minutos Utilizados</small>
                                                            <h3><?php echo $MinutosUtilizados; ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="invoice__attrs__item">
                                                            <small>Minutos Restantes</small>
                                                            <h3><?php echo $MinutosRestantes; ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="invoice__attrs__item">
                                                            <small>Llamadas Realizadas</small>
                                                            <h3><?php echo $CantidadLlamadas; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                    $Planes = $SipTelecomClass->getPlanActivado($_SESSION["userID"]);
                                                    if(count($Planes) > 0){
                                                        foreach($Planes as $Plan){
                                                            $NombrePlan = $Plan["nombre"];
                                                            $fechaActivacion = $Plan["fechaActivacion"];
                                                            $fechaCulminacion = $Plan["fechaCulminacion"];
                                                ?>
                                                            <div class="row" style="margin-top: 25px;">
                                                                <div class="col-sm-3"></div>
                                                                <div class="col-sm-6">
                                                                    <div class="invoice__attrs__item">
                                                                        <small>Plan Activado</small>
                                                                        <h3><?php echo $NombrePlan; ?></h3>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3"></div>
                                                                <div class="col-sm-3"></div>
                                                                <div class="col-sm-6">
                                                                    <div class="col-sm-6" style="padding: 0; float: left;">
                                                                        <div class="invoice__attrs__item">
                                                                            <small>Fecha de Activación</small>
                                                                            <h3><?php echo $fechaActivacion; ?></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6" style="padding: 0; float: left;">
                                                                        <div class="invoice__attrs__item">
                                                                            <small>Fecha de Culminacion</small>
                                                                            <h3><?php echo $fechaCulminacion; ?></h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3"></div>
                                                            </div>
                                                <?php
                                                        }
                                                    }else{
                                                        $NombrePlan = " Sin plan asociado";
                                                        $fechaActivacion = "-";
                                                        $fechaCulminacion = "-";
                                                ?>
                                                        <div class="row" style="margin-top: 25px;">
                                                            <div class="col-sm-3"></div>
                                                            <div class="col-sm-6">
                                                                <div class="invoice__attrs__item">
                                                                    <small>Plan Activado</small>
                                                                    <h3><?php echo $NombrePlan; ?></h3>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3"></div>
                                                            <div class="col-sm-3"></div>
                                                            <div class="col-sm-6">
                                                                <div class="col-sm-6" style="padding: 0; float: left;">
                                                                    <div class="invoice__attrs__item">
                                                                        <small>Fecha de Activación</small>
                                                                        <h3><?php echo $fechaActivacion; ?></h3>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6" style="padding: 0; float: left;">
                                                                    <div class="invoice__attrs__item">
                                                                        <small>Fecha de Culminacion</small>
                                                                        <h3><?php echo $fechaCulminacion; ?></h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3"></div>
                                                        </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            break;
                        }
                    }
                ?>