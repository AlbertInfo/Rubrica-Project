<?php
namespace ContactManagement;

interface UpdateContactContract {

    public  function getDb();

    public function setDb();

    public function selectContact( int $id);

    public function setImage(int $imageId, string $picture);

    public function showContactInfo(array $selectedContact);

    public function updateContactInfo(array $data, int $pictureId, string $pictureTmpName, int $contactId);

    public  function updateContactImage(array $file, array $newContactInfo, $contactId);
}