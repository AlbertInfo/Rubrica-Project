<?php

namespace Database;
//Questa è una classe  DTO CHE setta la configurazione del db;
class DBConfig
{

    public string $host;
    
    public string $dbName;


    public string $port;

    public string $user;

    public string $password;

    public function __construct($host, $port, $user, $password, $dbName)
    {

        $this->host = $host;
        $this->dbName = $dbName;
        $this->port = $port;
        $this->user  = $user;
        $this->password = $password;
    }


}


