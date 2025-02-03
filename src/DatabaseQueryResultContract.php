<?php
namespace Alberto\RubricaProject;

interface DatabaseQueryResultContract
{
    public function fetch();
    public function fetchAll();
}
