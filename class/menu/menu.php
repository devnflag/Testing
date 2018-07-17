<?php
    class Menu{

        function getMenu(){
            $SqlMenuRoot = "select
                                M.*
                            from
                                usuarios U
                                    INNER JOIN clientes_usuarios CU on CU.idUsuario = U.id
                                    INNER JOIN clientes C on C.id = CU.idCliente
                                    INNER JOIN clientes_servicios CS on CS.idCliente = C.id
                                    INNER JOIN servicios S on S.id = CS.idServicio
                                    INNER JOIN menu M on M.idServicio = S.id
                            WHERE
                                M.idPadre = '0' AND
                                U.id = '".$_SESSION["userID"]."'";
            $MenuRoot = $db->select($SqlMenuRoot);
            $ToReturn = "";
            foreach($MenuRoot as $Root){
                $ToReturn .= "<li class='navigation__sub @@".$Root["Descripcion"]."'>";
                    $ToReturn .= "<a href=''><i class='".$Root["Logo"]."'></i> ".$Root["Descripcion"]."</a>";
                    $SqlMenuChild = "select * from menu where idPadre='".$Root["id"]."'";
                    $MenuChild = $db->select($SqlMenuChild);
                    if(count($MenuChild) > 0){
                        $ToReturn .= "<ul>";
                            foreach($MenuChild as $Child){
                                $ToReturn .= "<li class='@@".$Child["id"]."'><a href='hidden-sidebar.html'>".$Child["Descripcion"]."</a></li>";
                            }
                        $ToReturn .= "</ul>";
                    }
                $ToReturn .= "</li>";
            }
            return $ToReturn;
        }
    }
?>