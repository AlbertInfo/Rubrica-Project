<?php
namespace ContactManagement;

use Database\DatabaseContract;

interface ContactManagementContract {

    public  function getDb();

    public function setDb();

    // public static function setImage(array $file);

    // public static function addContact(array $info, array $file);

    public  function contactsList();
}