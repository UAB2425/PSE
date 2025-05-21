<?php

namespace App\DataFixtures;

use App\Entity\JDVAdmin;
use App\Entity\JDVContent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JDVFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Adaugă administrator
        $admin = new JDVAdmin();
        $admin->setUsername('admin');
        $admin->setPassword('parola123');
        $manager->persist($admin);
        
        // Conținutul paginii
        $content = new JDVContent();
        $content->setTitle('Pagina Personală - Jibotean Denis-Virgil');
        $content->setParagraphOne('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $content->setParagraphTwo('Pellentesque habitant morbi tristique senectus et netus.');
        $content->setSkills(['Dezvoltare web', 'Programare', 'Baze de date', 'Design']);
        $content->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($content);
        
        $manager->flush();
    }
}
