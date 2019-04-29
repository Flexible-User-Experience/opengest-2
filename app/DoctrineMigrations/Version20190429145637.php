<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190429145637 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sale_delivery_note ADD sale_request_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sale_delivery_note ADD CONSTRAINT FK_3FA6B46ABF2A5CE1 FOREIGN KEY (sale_request_id) REFERENCES sale_request (id)');
        $this->addSql('CREATE INDEX IDX_3FA6B46ABF2A5CE1 ON sale_delivery_note (sale_request_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sale_delivery_note DROP FOREIGN KEY FK_3FA6B46ABF2A5CE1');
        $this->addSql('DROP INDEX IDX_3FA6B46ABF2A5CE1 ON sale_delivery_note');
        $this->addSql('ALTER TABLE sale_delivery_note DROP sale_request_id');
    }
}
