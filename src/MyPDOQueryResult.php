<?php

namespace Alberto\RubricaProject;


use PDOStatement;




class MyPDOQueryResult implements DatabaseQueryResultContract
{

    private PDOStatement $statement;

    public function __construct(PDOStatement $statement)
    {
        $this->statement = $statement;
    }


    public function fetch(): mixed
    {

        return $this->statement->fetch();
    }


    public function fetchAll(): array
    {

        return $this->statement->fetchAll();
    }
}
