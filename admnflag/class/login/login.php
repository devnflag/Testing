<?php
    class Login{

        function getUserMatch($User,$Password){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;

            $SqlUsernameMatch = "select * from usuarios_admnflag where usuario='".$User."' LIMIT 1";
            $UsernameMatch = $db->select($SqlUsernameMatch);
            if(count($UsernameMatch) > 0){

                $userID = $UsernameMatch[0]["id"];

                $SqlPasswordMatch = "select * from usuarios_admnflag where id='".$userID."' and password='".$Password."'";
                $PasswordMatch = $db->select($SqlPasswordMatch);
                if(count($PasswordMatch) > 0){
                    $ToReturn["result"] = true;
                    $_SESSION["userID_admnflag"] = $userID;
                }
            }
            return $ToReturn;
        }
    }
?>