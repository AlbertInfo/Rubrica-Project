<?php
namespace ContactManagement;

use Database\DatabaseContract;

interface ContactsListContract {

    public  function getDb();

    public function setDb();

    public  function contactsList();
}