<?php

namespace ContactManagement;

interface AddContactContract
{

    public  function getDb();

    public function setDb();

    public function setImage(array $file);

    public function addContact(array $info,  array $file);
}
