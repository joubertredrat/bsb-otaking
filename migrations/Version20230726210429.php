<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726210429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fansub (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hentai_title (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alternative_names LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', type VARCHAR(5) NOT NULL, language VARCHAR(10) NOT NULL, episodes INT NOT NULL, status_download VARCHAR(20) NOT NULL, status_view VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hentai_title_fansub (hentai_title_id INT NOT NULL, fansub_id INT NOT NULL, INDEX IDX_77C5A0E0FFBDB793 (hentai_title_id), INDEX IDX_77C5A0E0BA134867 (fansub_id), PRIMARY KEY(hentai_title_id, fansub_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(20) NOT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_hentai_title (tag_id INT NOT NULL, hentai_title_id INT NOT NULL, INDEX IDX_A4DCF7BCBAD26311 (tag_id), INDEX IDX_A4DCF7BCFFBDB793 (hentai_title_id), PRIMARY KEY(tag_id, hentai_title_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_file (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_file_hentai_title (video_file_id INT NOT NULL, hentai_title_id INT NOT NULL, INDEX IDX_242A68E5762690C1 (video_file_id), INDEX IDX_242A68E5FFBDB793 (hentai_title_id), PRIMARY KEY(video_file_id, hentai_title_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hentai_title_fansub ADD CONSTRAINT FK_77C5A0E0FFBDB793 FOREIGN KEY (hentai_title_id) REFERENCES hentai_title (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hentai_title_fansub ADD CONSTRAINT FK_77C5A0E0BA134867 FOREIGN KEY (fansub_id) REFERENCES fansub (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_hentai_title ADD CONSTRAINT FK_A4DCF7BCBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_hentai_title ADD CONSTRAINT FK_A4DCF7BCFFBDB793 FOREIGN KEY (hentai_title_id) REFERENCES hentai_title (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_file_hentai_title ADD CONSTRAINT FK_242A68E5762690C1 FOREIGN KEY (video_file_id) REFERENCES video_file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_file_hentai_title ADD CONSTRAINT FK_242A68E5FFBDB793 FOREIGN KEY (hentai_title_id) REFERENCES hentai_title (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hentai_title_fansub DROP FOREIGN KEY FK_77C5A0E0FFBDB793');
        $this->addSql('ALTER TABLE hentai_title_fansub DROP FOREIGN KEY FK_77C5A0E0BA134867');
        $this->addSql('ALTER TABLE tag_hentai_title DROP FOREIGN KEY FK_A4DCF7BCBAD26311');
        $this->addSql('ALTER TABLE tag_hentai_title DROP FOREIGN KEY FK_A4DCF7BCFFBDB793');
        $this->addSql('ALTER TABLE video_file_hentai_title DROP FOREIGN KEY FK_242A68E5762690C1');
        $this->addSql('ALTER TABLE video_file_hentai_title DROP FOREIGN KEY FK_242A68E5FFBDB793');
        $this->addSql('DROP TABLE fansub');
        $this->addSql('DROP TABLE hentai_title');
        $this->addSql('DROP TABLE hentai_title_fansub');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_hentai_title');
        $this->addSql('DROP TABLE video_file');
        $this->addSql('DROP TABLE video_file_hentai_title');
    }
}
