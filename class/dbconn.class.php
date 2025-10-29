<?php
class DBConnection
{

    private $hostname = "192.168.200.22";
    private $username = "sa";
    private $password = "ChmcStgngDB_2023";
    private $database = "CHMC-TAT";
    private $charset = "UTF8";

    // private $hostname = "localhost";
    // private $username = "sa";
    // private $password = "Root";
    // private $database = "CHMC-TAT";
    // private $charset = "UTF8";


    // protected function mysql_connect(){
    //     $dsn = 'mysql:host='.$this->hostname.';dbname='.$this->database.';charset='.$this->charset;
    //     $pdo = new PDO($dsn, $this->username, $this->password);
    //     $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    //     return $pdo;
    // }

    public function mssql_connect()
    {
        // $dsn = 'sqlsrv:Server='.$this->hostname.';Database='.$this->database.'"'.$this->username.'"'.$this->password.'"';
        // $pdo = new PDO($dsn, $this->username, $this->password);

        $dsn = 'sqlsrv:Server=' . $this->hostname . ';Database=' . $this->database;
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }

    public function getConnection()
    {
        return $this->mssql_connect();
    }
}