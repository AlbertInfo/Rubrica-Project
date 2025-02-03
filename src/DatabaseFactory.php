<?php

namespace Alberto\RubricaProject;
use Exception;
use PDO;
use PDOException;
use Dotenv\Dotenv;

//Questo è un factory pattern, abbiamo portato dentro questa classe
//una istanza di creazione della connessione a db.
class DatabaseFactory
{



    // il metodo create restuisce un database contract o una pdo? 
    public static function Create(string $type = DatabaseContract::TYPE_PDO): DatabaseContract | null
    {

        $dbConfig = self::GetDBConfig();

        if ($type == DatabaseContract::TYPE_PDO) {
            return self::CreateWithPdo($dbConfig);
        }
        if ($type == DatabaseContract::TYPE_MySQLi) {
            return self::CreateWithMySQLi($dbConfig);
        }

        throw new Exception("Not Implemented!");
    }

    private static function CreateWithPdo(DbConfig $dbConfig)
    {

        try {

            $pdo = new MyPDO($dbConfig); // creo una istanza della classe MyPDO che sta in src/MyPDO.php

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {

            throw  new Exception("Database connection failed :{$e->getMessage()}");
        }
    }

    private static function CreateWithMySQLi(DbConfig $dbConfig): MySQLi
    {

        try {

            $mysqli = new MySQLi($dbConfig); // creo una istanza della classe MyPDO che sta in src/MyPDO.php


            return $mysqli;
        } catch (Exception $e) {

            throw  new Exception("Database connection failed :{$e->getMessage()}");
        }
    }

    private static function GetDBConfig(): DBConfig
    {

        //Implementazione della libreria DOT ENV

        //Assegno ad una variabile la creazione di una dotenv immutabile
        //Questo metodo chiama una factory
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../"); // Devo passare la variabile DIR che mappa la directory del progetto
        $dotenv->load(); //carico le variabili di ambiente.
        //Con questa riga di codice : attribusico il required a i parametri di configurazione
        //In questo modo rimane più facile isolare un ipotetico problema relativo alle credenziali
        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT']);

        $host = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_NAME'];
        $port = $_ENV['DB_PORT'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        //Creo una istanza di DBConfig e passo i parametri di connessione del db
        //cosa da non fare quando si va in produzione. vedi sopra soluzione migliore
        // $statement->debubDumpParamas() : mi permette di vedere lo stato
        //e le informazione dello statement
        return  new DBConfig(
            $host,
            $port,
            $user,
            $pass,
            $dbName
        );
    }
}
