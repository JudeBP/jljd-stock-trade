<?php

class dbConn
{
    private $server;
    private $db;
    private $username;
    private $password;

    protected function connect()
    {
        // Using XAMPP, credentials/db.ini is outside htdocs
        // In host/s file manager, outside public_html
        $conf = parse_ini_file('../../../credentials/db.ini');
        $this->db = $conf['db'];
        $this->username = $conf['username'];
        $this->password = $conf['password'];
        $this->server = $conf['server'];

        $conn = mysqli_connect($this->server, $this->username, $this->password, $this->db);
        if(mysqli_connect_errno()){
            header("Location: db-error.php");
            exit();
        }        
        
        return $conn;
    }
}
