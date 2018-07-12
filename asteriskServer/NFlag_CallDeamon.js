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

ami.on('eventCdr', function(data){
    var evt = data;
    console.log(evt);
});