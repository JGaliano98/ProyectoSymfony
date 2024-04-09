<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409102254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asignatura ADD nota_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE asignatura ADD CONSTRAINT FK_9243D6CEA98F9F02 FOREIGN KEY (nota_id) REFERENCES nota (id)');
        $this->addSql('CREATE INDEX IDX_9243D6CEA98F9F02 ON asignatura (nota_id)');
        $this->addSql('ALTER TABLE nota ADD alumno_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nota ADD CONSTRAINT FK_C8D03E0DFC28E5EE FOREIGN KEY (alumno_id) REFERENCES alumno (id)');
        $this->addSql('CREATE INDEX IDX_C8D03E0DFC28E5EE ON nota (alumno_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asignatura DROP FOREIGN KEY FK_9243D6CEA98F9F02');
        $this->addSql('DROP INDEX IDX_9243D6CEA98F9F02 ON asignatura');
        $this->addSql('ALTER TABLE asignatura DROP nota_id');
        $this->addSql('ALTER TABLE nota DROP FOREIGN KEY FK_C8D03E0DFC28E5EE');
        $this->addSql('DROP INDEX IDX_C8D03E0DFC28E5EE ON nota');
        $this->addSql('ALTER TABLE nota DROP alumno_id');
    }
}
