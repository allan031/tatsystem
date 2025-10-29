<?php

Class DBConnectionBizbox{

    private $hostname = "localhost";
    private $username = "sa";
    private $password = "ChmcStgngDB_2023";
    private $database = "Staging_TAT";
    private $charset = "UTF8";

    public function mssql_connect_bizbox(){
        $dsn = 'sqlsrv:Server='.$this->hostname.';Database='.$this->database;
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;

    }
}


?>