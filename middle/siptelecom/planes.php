                <header class="content__title">
                    <h1>Planes y Servicios</h1>
                    <small>Conozca todos los planes que tenemos para usted</small>
                </header>

                <div class="row price-table price-table--highlight">
                    <?php
                        $SipTelecomClass = new SipTelecom();
                        $ExtensionesClass = new Extensiones();
                        $Planes = $SipTelecomClass->getPlanes();
                        $ExistenNumerosInbound = $ExtensionesClass->ExistenNumerosInbound();
                        $Cont = 1;
                        foreach($Planes as $Plan){
                            if($Cont % 2 == 0){
                                $Popular = "price-table__item--popular";
                            }else{
                                $Popular = "";
                            }
                            ?>
                                <div class="col-md-4">
                                    <div class="price-table__item <?php echo $Popular; ?>">
                                        <header class="price-table__header">
                                            <div class="price-table__title"><?php echo $Plan["nombre"]; ?></div>
                                            <div class="price-table__desc"><?php echo $Plan["descripcion"]; ?></div>
                                        </header>
                                        <div class="price-table__price">
                                            <?php echo "$ ". number_format($Plan["precio"],0,',','.'); ?>
                                        </div>
                                        <ul class="price-table__info">
                                            <?php
                                                $Caracteristicas = $SipTelecomClass->getCaracteristicasPlanes($Plan["id"]);
                                                foreach($Caracteristicas as $Caracteristica){
                                                    ?>
                                                        <li><?php echo $Caracteristica["caracteristica"]; ?></li>
                                                    <?php
                                                }
                                            ?>
                                        </ul>
                                        <?php
                                            if($Plan["inbound"] == "1"){
                                                if($ExistenNumerosInbound){
                                                    ?>
                                                        <a id="<?php echo "$ ". number_format($Plan["precio"],0,',','.')."_".$Plan["id"]; ?>" class="select_plan price-table__action">CONTRATAR</a>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                    <a id="<?php echo "$ ". number_format($Plan["precio"],0,',','.')."_".$Plan["id"]; ?>" class="select_plan price-table__action">CONTRATAR</a>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php
                            $Cont++;
                        }
                    ?>
                </div>