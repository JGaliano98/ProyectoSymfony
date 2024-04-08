<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403062741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno ADD tutor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT FK_1435D52D208F64F1 FOREIGN KEY (tutor_id) REFERENCES tutor (id)');
        $this->addSql('CREATE INDEX IDX_1435D52D208F64F1 ON alumno (tutor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno DROP FOREIGN KEY FK_1435D52D208F64F1');
        $this->addSql('DROP INDEX IDX_1435D52D208F64F1 ON alumno');
        $this->addSql('ALTER TABLE alumno DROP tutor_id');
    }
}
