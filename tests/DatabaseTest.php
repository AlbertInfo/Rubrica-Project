<?php
use PHPUnit\Framework\TestCase;
use Alberto\RubricaProject\DatabaseFactory;
use Alberto\RubricaProject\DatabaseContract;

class DatabaseTest extends TestCase {
    private $db;

    protected function setUp(): void {
        $this->db = DatabaseFactory::Create(DatabaseContract::TYPE_PDO);
    }

    public function testDatabaseConnection() {
        $this->assertNotNull($this->db, "La connessione al database non dovrebbe essere nulla");
    }

    public function testFetchContact() {
        $result = $this->db->getData("SELECT * FROM contacts LIMIT 1");
        $this->assertNotFalse($result, "La query dovrebbe restituire un risultato");
    }
}

class ContactOperationsTest extends TestCase {
    private $db;

    protected function setUp(): void {
        $this->db = DatabaseFactory::Create(DatabaseContract::TYPE_PDO);
    }

    public function testInsertContact() {
        $name = "Mario";
        $surname = "Rossi";
        $email = "mario.rossi@example.com";
        
        $result = $this->db->setData(
            "INSERT INTO contacts (name, surname, email) VALUES (?, ?, ?)",
            [$name, $surname, $email]
        );
        
        $this->assertTrue($result, "Il contatto dovrebbe essere inserito con successo");
    }

    public function testDeleteContact() {
        $contactId = 1; // Supponendo che esista un ID 1
        
        $result = $this->db->setData("DELETE FROM contacts WHERE id = ?", [$contactId]);
        
        $this->assertTrue($result, "Il contatto dovrebbe essere eliminato con successo");
    }
}
