<?php
//Attraverso il namespace impostato come da composer.json riesco a fare l'autoload delle classi senza
//dover fare require dei singoli file.php
namespace Alberto\RubricaProject;

use Alberto\RubricaProject\DatabaseContract;
use Exception;

//PDO è UNA classe nativa di php e richiede lo slash prima 
class MyPDO extends \PDO implements DatabaseContract
{

    public function __construct(DBConfig $dBConfig)
    {
        $dsn = $this->getDsn($dBConfig->host, $dBConfig->port, $dBConfig->dbName);
        $username = $dBConfig->user;
        $password = $dBConfig->password;
        $options = [];
        // questo costruttore è ereditata dalla classe PDO di php che
        // vuole i seguenti parametri
        parent::__construct($dsn, $username, $password, $options);
    }

    public function getData(string $query, array $params = []): DatabaseQueryResultContract

    {
        // $query = "SELECT * FROM " . $tableName;
        $statement = $this->prepare($query);
        $statement->execute($params);
        //Fetch all restituisce tutti i dati 
        return new MyPDOQueryResult($statement);
    }

    public function setData(string $command, array $items): void
    {

        $statement = $this->prepare($command);

        foreach ($items as $item) {
            $statement->execute($item);
        }
    }

    public function doWithTransaction(array $operations): void
    {
        try {

            $this->beginTransaction(); //comincia la transazione

            foreach($operations as $operation){
                $this->exec($operation); //predispone lo statement
            }

            $this->commit(); //esegue le operazioni contro il db

        } catch (\Exception $error) {
            
            $this->rollBack(); //abortisce lo script se cè un errore
            
            throw new \Exception("Transaction aborted : " . $error->getMessage());
        }
           
    }

    /**
     
     * Summary of getDsn
     * @param string $host
     * @param string $port
     * @param string $dbName
     * @return string
     */


    //Questa funzione restituisce le infomrazioni per la connessione a db.
    private function getDsn(string $host, string  $port, string $dbName)
    {

        return
            "mysql:
        host={$host};
        port={$port};
        dbname={$dbName}";
    }
}
