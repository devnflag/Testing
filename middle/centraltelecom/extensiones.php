                <header class="content__title">
                    <h1>Extensiones</h1>
                    <small>Monitoree y Configure sus extensiones.</small>
                </header>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tabla de Extensiones</h4>
                        <div class="row" style="margin: 0px 15px;">
                            <button data-toggle="modal" data-target="#newExtension" class="btn btn-primary">Agregar</button>
                        </div>
                        <div class="groupsExtensions">
                            <?php
                                $CentralTelecomClass = new CentralTelecom();
                                $Year = date("Y");
                                $Month = date("m");
                                $Extensiones = $CentralTelecomClass->getExtensions($_SESSION["idCliente"], $Month, $Year);
                                foreach($Extensiones as $Extension){
                                    $TextoHabilitacion = "";
                                    $DisabledClass = "";
                                    switch($Extension["Estatus"]){
                                        case "1":
                                            $TextoHabilitacion = "Inhabilitar";
                                        break;
                                        case "0":
                                            $TextoHabilitacion = "Habilitar";
                                            $DisabledClass = "Disabled";
                                        break;
                                    }
                                    ?>
                                        <div class="Extension <?php echo $DisabledClass; ?>" id="<?php echo $Extension["Extension"]; ?>">
                                            <div class="nombreExtension"><?php echo $Extension["nombreExtension"]; ?></div>
                                            <div class="groupExtension">
                                                <div class="miniGroup">
                                                    <div class="number"><?php echo $Extension["Extension"]; ?></div>
                                                    <div class="text">Extensión</div>
                                                </div>
                                                <div class="miniGroup">
                                                    <div class="number"><?php echo $Extension["Clave"]; ?></div>
                                                    <div class="text">Clave</div>
                                                </div>
                                            </div>
                                            <div class="groupExtension">
                                                <div class="miniGroup">
                                                    <div class="number"><?php echo $Extension["LlamadasRealizadas"]; ?></div>
                                                    <div class="text">Llamadas</div>
                                                </div>
                                                <div class="miniGroup">
                                                    <div class="number"><?php echo $Extension["MinutosUtilizados"]; ?></div>
                                                    <div class="text">Minutos</div>
                                                </div>
                                            </div>
                                            <div class="actions">
                                                <div class="dropdown actions__item">
                                                    <i class="zmdi zmdi-more-vert" data-toggle="dropdown"></i>

                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item Update" >Modificar</a>
                                                        <a class="dropdown-item Habilitacion" ><?php echo $TextoHabilitacion; ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

<div class="modal fade" id="newExtension" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Nueva Extensión</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <h6>Nombre de Extensión</h6>
                    <input type="text" name="nombreExtension" class="form-control form-control-lg">
                    <i class="form-group__bar"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="new" class="btn btn-success">Agregar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateExtension" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Actualiza Extensión</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <h6>Nombre de Extensión</h6>
                    <input type="text" name="nombreExtension_update" class="form-control form-control-lg">
                    <i class="form-group__bar"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="update" class="btn btn-success">Actualizar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>