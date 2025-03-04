<?php

namespace ContactManagement;

require_once __DIR__ . '/../../vendor/autoload.php'; //caricare l'autoloader;
require_once __DIR__ . '/../../common.php';

use App\Helper;
use Database\GetDbTest;
use ContactManagement\ContactsListContract;
use Database\DatabaseContract;
use Database\DatabaseFactory;
use Database\DBConfig;
use Database\MyPDO;

class ContactsList implements ContactsListContract
{

    public  ?MyPDO  $db = null;

    public  function getDb()
    {

        return $this->db;
    }

    public function setDb()
    {

        $this->db = GetDbTest::getDb();
    }


    public  function contactsList()
    {
        if($this->db == null){

            $this->setDb();
        }

        $data = $this->db->getData("SELECT * FROM contacts ");

        $contacts = $data->fetchAll();

        return $contacts;
    }

}
