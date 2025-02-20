<?php
namespace Database;

interface DatabaseQueryResultContract
{
    public function fetch();
    public function fetchAll();
}
