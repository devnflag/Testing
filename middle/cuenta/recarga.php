                <?php
                    $GlobalClass = new Globals();
                    $Dolar = $GlobalClass->getDolarTasa();
                ?>
                <header class="content__title">
                    <h1>Recarga</h1>
                    <small>Recargue su saldo para poder disfrutar de nuestro excelente servicio de llamadas internacionales</small>
                </header>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Metodos de pago</h4>
                        <h6 class="card-subtitle">Elija el metodo de pago que mas se adapte a usted.</h6>

                        <div class="tab-container">
                            <ul class="nav nav-tabs nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#depositotransferencia" role="tab" aria-expanded="false">Deposito ó Transferencia</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#flow" role="tab" aria-expanded="false">Flow</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#paypal" role="tab" aria-expanded="false">Paypal</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="depositotransferencia" role="tabpanel" aria-expanded="true">
                                    <p>Debe hacer el deposito o transferencia a la siguiente cuenta:</p>
                                    <table class="table table-bordered invoice__table">
                                        <tbody>
                                            <tr>
                                                <td>TITULAR</td>
                                                <td>JONATHAN URBINA</td>
                                            </tr>
                                            <tr>
                                                <td>RUT</td>
                                                <td>25.858.538-0</td>
                                            </tr>
                                            <tr>
                                                <td>BANCO</td>
                                                <td>ITAU</td>
                                            </tr>
                                            <tr>
                                                <td>TIPO DE CUENTA</td>
                                                <td>CORRIENTE</td>
                                            </tr>
                                            <tr>
                                                <td>NUMERO DE CUENTA</td>
                                                <td>0213335996</td>
                                            </tr>
                                            <tr>
                                                <td>E-MAIL</td>
                                                <td>SALES@NFLAG.IO</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p>Una vez hecha la transferencia o el deposito registrar su pago enviandonos el recibo de pago mediante el siguiente formulario:</p>
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Registro de Pago</h4>
                                            <h6 class="card-subtitle">Complete los datos para poder registrar correctamente su pago.</h6>
                                            <div class="form-group col-sm-4">
                                                <span>Metodo de pago</span>
                                                <select class="select2 select2-hidden-accessible" name="tipoComprobante" tabindex="-1" aria-hidden="true">
                                                    <option value="">Seleccione</option>
                                                    <option value="Deposito">Deposito</option>
                                                    <option value="Transferencia">Transferencia</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <form class="dropzone dz-clickable" id="dropzoneComprobantes"><div class="dz-default dz-message"><span>Deje aqui su comprobante</span></div></form>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary" name="Registrar">Registrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="flow" role="tabpanel">
                                    <div class="row" style="display: none;">
                                        <div class="col-sm-4"></div>
                                        <div class="card col-sm-4">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <h6>Ingrese la cantidad de Pesos</h6>
                                                    <input type="text" name="pesosChileFlow" class="form-control form-control-lg">
                                                    <i class="form-group__bar"></i>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-primary" name="pagarFlow" style="width: 100%;" >PAGAR</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="paypal" role="tabpanel">
                                    <div class="row">
                                        <div class="col-sm-4"></div>
                                        <div class="card col-sm-4">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <h6>Ingrese la cantidad de Pesos</h6>
                                                    <input type="text" name="pesosChile" class="form-control form-control-lg">
                                                    <i class="form-group__bar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"></div>
                                        <div class="card col-sm-4">
                                            <div class="row">
                                                <table class="table table-bordered invoice__table" style="margin: 0px;">
                                                    <tr>
                                                        <th>Tasa</th>
                                                        <td id="tasaDolar">$ <?php echo $Dolar; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Comisión Paypal 1</th>
                                                        <td id="comisionPaypal1">0 $</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Comisión por Transferencia</th>
                                                        <td id="comisionPaypal2">1 $</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Dolares</th>
                                                        <td id="Dolares">0 $</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total</th>
                                                        <td id="totalDolares">0 $</td>
                                                    </tr>
                                                </table>
                                                <button class="btn btn-primary" name="pagarPaypal" style="width: 100%;" >PAGAR</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>