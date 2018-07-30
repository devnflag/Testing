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
            //db.query("SELECT DST.minutos as Minutos, (DST.minutos * 60) as Segundos, Us.id as idUsuario, DST.saldo as Saldo FROM Extensiones Ex INNER JOIN usuarios Us on Us.id = Ex.idUsuario INNER JOIN data_sipTelecom DST on DST.idUsuario = Us.id WHERE Ex.Extension='"+Extension+"'", function (err, recordset) {
            //db.query("SELECT DST.segundos as Segundos, Us.id as idUsuario, DST.saldo as Saldo FROM Extensiones Ex INNER JOIN usuarios Us on Us.id = Ex.idUsuario INNER JOIN data_sipTelecom DST on DST.idUsuario = Us.id WHERE Ex.Extension='"+Extension+"'", function (err, recordset) {
            db.query("SELECT DST.segundos as Segundos, Us.id as idUsuario,C.saldo as Saldo, C.id as idCliente FROM Extensiones Ex INNER JOIN usuarios Us on Us.id = Ex.idUsuario INNER JOIN data_sipTelecom DST on DST.idUsuario = Us.id INNER JOIN clientes_usuarios CU on CU.idUsuario = Us.id INNER JOIN clientes C on C.id = CU.idCliente WHERE Ex.Extension='"+Extension+"'", function (err, recordset) {
                recordset = JSON.parse(JSON.stringify(recordset));
                if (err){
                }else{
                    var SegundosActuales = recordset[0]["Segundos"];
                    var SaldoActual = recordset[0]["Saldo"];
                    var idUsuario = recordset[0]["idUsuario"];
                    var idCliente = recordset[0]["idCliente"];
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
                        db.query("SELECT precioUnitarioMinuto as Precio FROM config_sipTelecom", function (err, recordset) {
                            recordset = JSON.parse(JSON.stringify(recordset));
                            if (err){
                            }else{
                                var PrecioUnitario = recordset[0]["Precio"];
                                var Minutos = (Duration / 60);
                                var Saldo = SaldoActual - (Minutos * PrecioUnitario);
                                console.log("UPDATE clientes SET saldo = '"+Saldo+"' where idCliente='"+idCliente+"'");
                                db.query("UPDATE clientes SET saldo = '"+Saldo+"' where idCliente='"+idCliente+"'", function (err, recordset) {
                                    //console.log(recordset);
                                    if (!err) {

                                    }
                                });
                            }
                        });
                    }
                }
            });
        });
    }
});