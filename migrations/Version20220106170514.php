<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106170514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autheur_livre (autheur_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_F2194EF3C6E59929 (autheur_id), INDEX IDX_F2194EF337D925CB (livre_id), PRIMARY KEY(autheur_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `integer` (id INT AUTO_INCREMENT NOT NULL, date_de_parution DATE NOT NULL, note INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre_genre (livre_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_1053AB9E37D925CB (livre_id), INDEX IDX_1053AB9E4296D31F (genre_id), PRIMARY KEY(livre_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE autheur_livre ADD CONSTRAINT FK_F2194EF3C6E59929 FOREIGN KEY (autheur_id) REFERENCES autheur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE autheur_livre ADD CONSTRAINT FK_F2194EF337D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_genre ADD CONSTRAINT FK_1053AB9E37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_genre ADD CONSTRAINT FK_1053AB9E4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE autheur_livre');
        $this->addSql('DROP TABLE `integer`');
        $this->addSql('DROP TABLE livre_genre');
    }
}
