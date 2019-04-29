<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190429161356 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sale_request ADD sale_delivery_note_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sale_request ADD CONSTRAINT FK_4E894D0D9C1DE698 FOREIGN KEY (sale_delivery_note_id) REFERENCES sale_delivery_note (id)');
        $this->addSql('CREATE INDEX IDX_4E894D0D9C1DE698 ON sale_request (sale_delivery_note_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sale_request DROP FOREIGN KEY FK_4E894D0D9C1DE698');
        $this->addSql('DROP INDEX IDX_4E894D0D9C1DE698 ON sale_request');
        $this->addSql('ALTER TABLE sale_request DROP sale_delivery_note_id');
    }
}
