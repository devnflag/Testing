<?php
    class Login{

        function getUserMatch($User,$Password){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;

            $SqlUsernameMatch = "select * from usuarios where nombreUsuario='".$User."' LIMIT 1";
            $UsernameMatch = $db->select($SqlUsernameMatch);
            if(count($UsernameMatch) > 0){

                $userID = $UsernameMatch[0]["id"];

                $SqlPasswordMatch = "select * from usuarios where id='".$userID."' and claveUsuario='".$Password."'";
                $PasswordMatch = $db->select($SqlPasswordMatch);
                if(count($PasswordMatch) > 0){
                    $ToReturn["result"] = true;
                    $_SESSION["userID"] = $userID;
                }
            }
            return $ToReturn;
        }
        function MailExist($Mail){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlMail = "select * from usuarios where nombreUsuario='".$Mail."'";
            $Mail = $db->select($SqlMail);
            if(count($Mail) > 0){
                $ToReturn["result"] = true;
                $ToReturn["Message"] = "Correo electronico ya existe, utilice la opción de recuperacion de contraseña.";
            }
            return $ToReturn;
        }
        function newUser($FullName,$DNI,$Mail,$Address,$Rol,$Password){
            $db = new DB();
            $ClientesClass = new Clientes();
            $ExtensionesClass = new Extensiones();
            $SipTelecomClass = new SipTelecom();
            $AGIClass = new AGI_AsteriskManager();
            
            $ToReturn = array();
            $ToReturn["result"] = false;
            
            $InsertCliente = $ClientesClass->addCliente($FullName,$DNI,$Mail,$Address,$Rol);
            if($InsertCliente){
                $Cliente = $ClientesClass->getClienteByMail($Mail);
                if($Cliente["result"]){
                    $Cliente = $Cliente["Data"];
                    $idCliente = $Cliente["id"];
                    $InsertUsuario = $this->addUser($Mail,$Password,$FullName,$Mail,$Rol,$idCliente);
                    if($InsertUsuario){
                        $Usuario = $this->getUserByUserName($Mail);
                        if($Usuario["result"]){
                            $Usuario = $Usuario["Data"];
                            $idUsuario = $Usuario["id"];
                            $Extension = $ExtensionesClass->newExtension($idUsuario);
                            $SipTelecomData = $SipTelecomClass->newData($idUsuario);
                            if($SipTelecomData["result"]){
                                $AGIClass->connect("localhost","nflag","nflag.,2112");
                                $ChannelsReponse = $AGIClass->command("reload");
                                $ToReturn["result"] = true;
                            }
                        }
                    }
                }
            }
            return $ToReturn;
        }
        function addUser($Username,$Password,$Nombre,$Mail,$Rol,$idCliente){
            $db = new DB();
            $ToReturn = false;
            $SqlInsertUser = "insert into usuarios (nombreUsuario,claveUsuario,nombre,correo,idRol,fechaCreacion) values('".$Username."','".$Password."','".$Nombre."','".$Mail."','".$Rol."',NOW())";
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
        function getUserData(){
            $db = new DB();
            $ToReturn = array();
            $SqlUsuario = "select * from usuarios where id='".$_SESSION["userID"]."'";
            $Usuario = $db->select($SqlUsuario);
            $Usuario = $Usuario[0];
            $ToReturn["Nombre"] = $Usuario["nombre"];
            $ToReturn["Correo"] = $Usuario["correo"];
            $ToReturn["Avatar"] = "";
            return $ToReturn;
        }
        function getUserByMail($Mail){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlUsuario = "select * from usuarios where correo='".$Mail."'";
            $Usuario = $db->select($SqlUsuario);
            if(count($Usuario) > 0){
                $ToReturn["Data"] = $Usuario[0];
                $ToReturn["result"] = true;
            }
            return $ToReturn;
        }
    }
?>