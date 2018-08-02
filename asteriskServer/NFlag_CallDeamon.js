var aio = require('asterisk.io');
var ami = null;

ami = aio.ami('localhost',5038,'nflag','nflag.,2112');

ami.on('error', function(err){
    err = JSON.parse(JSON.stringify(err));
    console.log(err);
});
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var port = process.env.PORT || 65530

http.listen(port);
require('events').EventEmitter.defaultMaxListeners = Infinity;


var fs = require('fs');
var ini = require('ini');


//var configIni = ini.parse(fs.readFileSync('../class/db/conf.ini', 'utf-8')); //RUTA WINDOWS
var configIni = ini.parse(fs.readFileSync('/var/www/html/class/db/conf.ini', 'utf-8')); //RUTA LINUX

configIni = configIni.nflagDB;


//var sql = require("mssql");
var mysql = require('mysql');
    // config for your database
    var config = {
        user: configIni.userDB,
        password: configIni.passDB,
        server: configIni.serverDB, 
        database: configIni.DB 
    };
    var db = mysql.createConnection({
        host: configIni.serverDB,
        user: configIni.userDB,
        password: configIni.passDB,
        database: configIni.DB
    });


db.connect(function(err) {
    if(err){
        console.log("Error con credenciales de Base de datos.");
    }else{
        ami.on('eventCdr', function(data){
            var evt = data;
            console.log(evt);
            var Duration = evt.BillableSeconds;
            var Extension = evt.Source;

            db.query("SELECT U.idServicio as idServicio FROM Extensiones E INNER JOIN clientes_usuarios CU on CU.idUsuario = E.idUsuario INNER JOIN usuarios U on U.id = CU.idUsuario WHERE E.Extension='"+Extension+"'", function (err, recordset) {
                recordset = JSON.parse(JSON.stringify(recordset));
                if (err){
                }else{
                    var idServicio = recordset[0]["idServicio"];
                    switch(idServicio){
                        case "1":
                        console.log("SELECT DCT.segundos as Segundos, C.saldo as Saldo, C.id as idCliente, DCT.idProveedor as idProveedor FROM Extensiones E INNER JOIN central_usuarios_centralTelecom CUCT ON CUCT.idUsuario = E.idUsuario INNER JOIN data_centralTelecom DCT on DCT.id = CUCT.idCentral INNER JOIN clientes C on C.id = DCT.idCliente WHERE E.Extension='"+Extension+"'");
                            db.query("SELECT DCT.segundos as Segundos, C.saldo as Saldo, C.id as idCliente, DCT.idProveedor as idProveedor FROM Extensiones E INNER JOIN central_usuarios_centralTelecom CUCT ON CUCT.idUsuario = E.idUsuario INNER JOIN data_centralTelecom DCT on DCT.id = CUCT.idCentral INNER JOIN clientes C on C.id = DCT.idCliente WHERE E.Extension='"+Extension+"'", function (err, recordset) {
                                recordset = JSON.parse(JSON.stringify(recordset));
                                if (err){
                                }else{
                                    var SegundosActuales = recordset[0]["Segundos"];
                                    var SaldoActual = recordset[0]["Saldo"];
                                    var idCliente = recordset[0]["idCliente"];
                                    var idProveedor = recordset[0]["idProveedor"];
                                    if(SegundosActuales > 0){
                                        var Segundos = SegundosActuales;
                                        Segundos -= Duration;
                                        console.log("UPDATE data_centralTelecom SET segundos = '"+Segundos+"' where idCliente='"+idCliente+"'");
                                        db.query("UPDATE data_centralTelecom SET segundos = '"+Segundos+"' where idCliente='"+idCliente+"'", function (err, recordset) {
                                            //console.log(recordset);
                                            if (!err) {
                                                if(Segundos <= 0){
                                                    /* db.query("DELETE FROM usuarios_planes_sipTelecom where idUsuario='"+idUsuario+"'", function (err, recordset) {
                                                        //console.log(recordset);
                                                        if (!err) {
                                                            
                                                        }
                                                    }); */
                                                }
                                            }
                                        });
                                    }else{
                                        console.log("SELECT precioMinuto as Precio from proveedores where id = '"+idProveedor+"'");
                                        //db.query("SELECT precioUnitarioMinuto as Precio FROM config_sipTelecom", function (err, recordset) {
                                        db.query("SELECT precioMinuto as Precio from proveedores where id = '"+idProveedor+"'", function (err, recordset) {
                                            recordset = JSON.parse(JSON.stringify(recordset));
                                            if (err){
                                            }else{
                                                var PrecioUnitario = recordset[0]["Precio"];
                                                var Minutos = (Duration / 60);
                                                var Saldo = SaldoActual - (Minutos * PrecioUnitario);
                                                console.log("UPDATE clientes SET saldo = '"+Saldo+"' where id='"+idCliente+"'");
                                                db.query("UPDATE clientes SET saldo = '"+Saldo+"' where id='"+idCliente+"'", function (err, recordset) {
                                                    //console.log(recordset);
                                                    if (!err) {
                
                                                    }
                                                });
                                            }
                                        });
                                    }
                                }
                            });
                        break;
                        case "2":
                            db.query("SELECT DST.segundos as Segundos, Us.id as idUsuario,C.saldo as Saldo, C.id as idCliente, DST.idProveedor as idProveedor FROM Extensiones Ex INNER JOIN usuarios Us on Us.id = Ex.idUsuario INNER JOIN data_sipTelecom DST on DST.idUsuario = Us.id INNER JOIN clientes_usuarios CU on CU.idUsuario = Us.id INNER JOIN clientes C on C.id = CU.idCliente WHERE Ex.Extension='"+Extension+"'", function (err, recordset) {
                                recordset = JSON.parse(JSON.stringify(recordset));
                                if (err){
                                }else{
                                    var SegundosActuales = recordset[0]["Segundos"];
                                    var SaldoActual = recordset[0]["Saldo"];
                                    var idUsuario = recordset[0]["idUsuario"];
                                    var idCliente = recordset[0]["idCliente"];
                                    var idProveedor = recordset[0]["idProveedor"];
                                    if(SegundosActuales > 0){
                                        var Segundos = SegundosActuales;
                                        Segundos -= Duration;
                                        console.log("UPDATE data_sipTelecom SET segundos = '"+Segundos+"' where idUsuario='"+idUsuario+"'");
                                        db.query("UPDATE data_sipTelecom SET segundos = '"+Segundos+"' where idUsuario='"+idUsuario+"'", function (err, recordset) {
                                            //console.log(recordset);
                                            if (!err) {
                                                if(Segundos <= 0){
                                                    db.query("DELETE FROM usuarios_planes_sipTelecom where idUsuario='"+idUsuario+"'", function (err, recordset) {
                                                        //console.log(recordset);
                                                        if (!err) {
                                                            
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    }else{
                                            //db.query("SELECT precioUnitarioMinuto as Precio FROM config_sipTelecom", function (err, recordset) {
                                            db.query("SELECT precioMinuto as Precio from proveedores where id = '"+idProveedor+"'", function (err, recordset) {
                                            recordset = JSON.parse(JSON.stringify(recordset));
                                            if (err){
                                            }else{
                                                var PrecioUnitario = recordset[0]["Precio"];
                                                var Minutos = (Duration / 60);
                                                var Saldo = SaldoActual - (Minutos * PrecioUnitario);
                                                console.log("UPDATE clientes SET saldo = '"+Saldo+"' where id='"+idCliente+"'");
                                                db.query("UPDATE clientes SET saldo = '"+Saldo+"' where id='"+idCliente+"'", function (err, recordset) {
                                                    //console.log(recordset);
                                                    if (!err) {
                
                                                    }
                                                });
                                            }
                                        });
                                    }
                                }
                            });
                        break;
                    }
                }
            });
        });
    }
});