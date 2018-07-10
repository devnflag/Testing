<?php
    class Db {
        public $Server;
        public $User;
        public $Pass;
        public $Database;

        public $Link;

        public $CrearLog;
        // The database connection
        protected static $connection;
        protected static $connectionDiscador;
        protected static $connectionDiscadorAsterisk;

        /**
         * Connect to the database
         *
         * @return bool false on failure / mysqli MySQLi object instance on success
         */
        public function __construct($Link = "nflag"){
            $this->Link = $Link;
            $Conf = parse_ini_file("conf.ini");
            if($Link == "nflag"){
                $this->Server = $Conf["serverDB"];
                $this->Pass = $Conf["passDB"];
                $this->User = $Conf["userDB"];
                $this->Database = $Conf["DB"];
            }
            else if($Link == "discador"){
                $this->Server = $Conf["serverDB_discador"];
                $this->Pass = $Conf["passDB_discador"];
                $this->User = $Conf["userDB_discador"];
                $this->Database = $Conf["DB_discador"];
            }
            else if($Link == "asterisk"){
                $this->Server = $Conf["serverDB_discador_asterisk"];
                $this->Pass = $Conf["passDB_discador_asterisk"];
                $this->User = $Conf["userDB_discador_asterisk"];
                $this->Database = $Conf["DB_discador_asterisk"];
                
            }
            if (!isset($_SESSION)){
                session_start();
            }
        }

        public function connect() {
            $ToReturn =  "";
            switch($this->Link){
                case "nflag":
                    // Try and connect to the database
                    if(!isset(self::$connection)) {
                        //self::$connection = mysql_connect($this->Server,$this->User,$this->Pass);
                        self::$connection = mysqli_connect($this->Server,$this->User,$this->Pass);
                        mysqli_select_db(self::$connection, $this->Database);
                        $this->query("SET NAMES 'utf8'");
                    }

                    // If connection was not successful, handle the error
                    if(self::$connection === false) {
                        // Handle error - notify administrator, log to a file, show an error screen, etc.
                        $ToReturn = false;
                    }
                    $ToReturn = self::$connection;
                break;
                case "discador":
                    // Try and connect to the database
                    if(!isset(self::$connectionDiscador)) {
                        self::$connectionDiscador = mysqli_connect($this->Server,$this->User,$this->Pass);
                        mysqli_select_db(self::$connectionDiscador, $this->Database);
                        $this->query("SET NAMES 'utf8'");
                    }

                    // If connection was not successful, handle the error
                    if(self::$connectionDiscador === false) {
                        // Handle error - notify administrator, log to a file, show an error screen, etc.
                        $ToReturn = false;
                    }
                    if($ToReturn !== false){

                    }
                    $ToReturn = self::$connectionDiscador;
                break;
                case "asterisk":
                    // Try and connect to the database
                    if(!isset(self::$connectionDiscadorAsterisk)) {
                        self::$connectionDiscadorAsterisk = mysqli_connect($this->Server,$this->User,$this->Pass);
                        mysqli_select_db(self::$connectionDiscadorAsterisk, $this->Database);
                        $this->query("SET NAMES 'utf8'");
                    }

                    // If connection was not successful, handle the error
                    if(self::$connectionDiscadorAsterisk === false) {
                        // Handle error - notify administrator, log to a file, show an error screen, etc.
                        $ToReturn = false;
                    }
                    if($ToReturn !== false){
                        echo "NOT CONNECTED";
                    }else{
                        echo "CONNECTED";
                    }
                    $ToReturn = self::$connectionDiscadorAsterisk;
                break;
            }
            return $ToReturn;
        }

        /**
         * Query the database
         *
         * @param $query The query string
         * @return mixed The result of the mysqli::query() function
         */
        public function query($query) {
            // Connect to the database
            $connection = $this -> connect();
            // Query the database
            $result = mysqli_query($connection, $query);
            if ($result){

            }else{
                $result = mysqli_error($connection);
                // echo $query;
            }
            return $result;
        }

        function getErrorMessage(){
            //return $this->Server."/".mysql_error();
            //return $this->Server."/".mysqli_error($link);
        }

        /**
         * Fetch rows from the database (SELECT query)
         *
         * @param $query The query string
         * @return bool False on failure / array Database rows on success
         */
        public function select($query) {
            $rows = array();
            $result = $this -> query($query);
            if($result === false) {
                return false;
            }
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            return $rows;
        }

        /**
         * Fetch the last error from the database
         *
         * @return string Database error message
         */
        public function error() {
            $connection = $this -> connect();
            return $connection -> error;
        }

        /**
         * Quote and escape value for use in a database query
         *
         * @param string $value The value to be quoted and escaped
         * @return string The quoted and escaped string
         */
        public function quote($value) {
            $connection = $this -> connect();
            //return "'" . $connection -> real_escape_string($value) . "'";
            return "'" . mysqli_real_escape_string($connection, $value) . "'";
        }

        public function getLastID(){
            $connection = $this -> connect();
            return mysqli_insert_id($connection);
        }

        public function getLastIDFromTable($field,$table){
            $Sql = "SELECT MAX(".$field.") AS id FROM ".$table;
            $Id = $this->select($Sql);
            return $Id[0]["id"];
        }
    }

    /*

    Examples:

        // Our database object
        $db = new Db();

        // Quote and escape form submitted values
        $name = $db -> quote($_POST['username']);
        $email = $db -> quote($_POST['email']);

        // Insert the values into the database
        $result = $db -> query("INSERT INTO `users` (`name`,`email`) VALUES (" . $name . "," . $email . ")");

        $db = new Db();
        $rows = $db -> select("SELECT `name`,`email` FROM `users` WHERE id=5");
    */
?>
