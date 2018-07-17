<?php
    class Login{

        function getUserMatch($User,$Password){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;

            $SqlUsernameMatch = "select * from usuarios where usuario='".$User."' LIMIT 1";
            $UsernameMatch = $db->select($SqlUsernameMatch);
            if(count($UsernameMatch) > 0){

                $userID = $UsernameMatch[0]["id"];

                $SqlPasswordMatch = "select * from usuarios where id='".$userID."' and password='".$Password."'";
                $PasswordMatch = $db->select($SqlPasswordMatch);
                if(count($PasswordMatch) > 0){
                    $ToReturn["result"] = true;
                    $_SESSION["userID"] = $userID;
                }
            }
            return $ToReturn;
        }
        function newUser($FullName,$DNI,$Mail,$Address,$Rol){
            $db = new DB();
            $ClientesClass = new Clientes();
            $ExtensionesClass = new Extensiones();
            $asm = new AGI_AsteriskManager();
            
            $ToReturn = array();
            $ToReturn["result"] = false;
            
            $InsertCliente = $ClientesClass->addCliente($FullName,$DNI,$Mail,$Address,$Rol);
            if($InsertCliente){
                $Cliente = $ClientesClass->getClienteByMail($Mail);
                if($Cliente["result"]){
                    $Cliente = $Cliente["Data"];
                    $idCliente = $Cliente["id"];
                    $InsertUsuario = $this->addUser($Mail,$Mail,$Rol,$idCliente);
                    if($InsertUsuario){
                        $Usuario = $this->getUserByUserName($Mail);
                        if($Usuario["result"]){
                            $Usuario = $Usuario["Data"];
                            $idUsuario = $Usuario["id"];
                            $Extension = $ExtensionesClass->newExtension($idUsuario);
                            $asm->connect("localhost","nflag","nflag");
                            $ChannelsReponse = $asm->command("reload");
                        }
                    }
                }
            }
        }
        function addUser($Username,$Password,$Rol,$idCliente){
            $db = new DB();
            $ToReturn = false;
            $SqlInsertUser = "insert into usuarios (nombreUsuario,claveUsuario,idRol,fechaCreacion) values('".$Username."','".$Password."','".$Rol."',NOW())";
            $InsertUser = $db->query($SqlInsertUser);
            if($InsertUser){
                $Usuario = $this->getUserByUserName($Username);
                if($Usuario["result"]){
                    $Usuario = $Usuario["Data"];
                    $idUsuario = $Usuario["id"];
                    $SqlInsertClienteUsuario = "insert into clientes_usuarios (idCliente,idUsuario) values('".$idCliente."','".$idUsuario."')";
                    $InsertClienteUSuario = $db->query($SqlInsertClienteUsuario);
                    if($InsertClienteUSuario){
                        $ToReturn = true;
                    }
                }
            }
            return $ToReturn;
        }
        function getUserByUserName($Username){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlUsuario = "select * from usuarios where nombreUsuario='".$Username."'";
            $Usuario = $db->select($SqlUsuario);
            if(count($Usuario) > 0){
                $ToReturn["Data"] = $Usuario[0];
                $ToReturn["result"] = true;
            }
            return $ToReturn;
        }
    }
?>