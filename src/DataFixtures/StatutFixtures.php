<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Statut;

class StatutFixtures extends Fixture
{
    public const STATUT_1 = 'statut 1';
    public const STATUT_2 = 'statut 2';
    public const STATUT_3 = 'statut 3';

    public function load(ObjectManager $manager): void
    {
        // Création des statuts
        $todo = new Statut();
        $todo->setLibelle('To Do');
        $manager->persist($todo);
        $this->addReference(self::STATUT_1, $todo);

        $doing = new Statut();
        $doing->setLibelle('Doing');
        $manager->persist($doing);
        $this->addReference(self::STATUT_2, $doing);
     
        $done = new Statut();
        $done->setLibelle('Done');
        $manager->persist($done);
        $this->addReference(self::STATUT_3, $done);

            $manager->flush();
    }
}
