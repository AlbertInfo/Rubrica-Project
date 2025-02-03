<?php
namespace Alberto\RubricaProject;
use mysqli_result;


class MySQLiQueryResult implements DatabaseQueryResultContract
{

    private mysqli_result $result;
    public function __construct(\mysqli_result $result)
    {
        $this->result = $result;
    }


    public function fetch()
    {

        return $this->result->fetch_assoc();
    }


    public function fetchAll()
    {

        return $this->result->fetch_all();
    }
}