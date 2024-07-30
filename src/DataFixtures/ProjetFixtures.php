<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Projet;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ProjetFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROJET_1 = 'projet 1';
    public const PROJET_2 = 'projet 2';
    public const PROJET_3 = 'projet 3';
    public const PROJET_4 = 'projet 4';
    public const PROJET_5 = 'projet 5';
    public const PROJET_6 = 'projet 6';
    public const PROJET_7 = 'projet 7';

    public function load(ObjectManager $manager): void
    {
        $faker = (new \Faker\Factory())::create('fr_FR');

        // Création des projets
        $projet1 = new Projet();
        $projet1
            ->setNom('TaskLinker')
            ->setArchive(false)
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_1))
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_4));
        $manager->persist($projet1);
        $this->addReference(self::PROJET_1, $projet1);


        $projet2 = new Projet();
        $projet2
            ->setNom('Application mobile Grand Nancy')
            ->setArchive(false)
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_2))
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_3));
        $manager->persist($projet2);
        $this->addReference(self::PROJET_2, $projet2);


        $projet3 = new Projet();
        $projet3
            ->setNom('Site vitrine Les Soeurs Marchand')
            ->setArchive(false)
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_2))
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_5));
        $manager->persist($projet3);
        $this->addReference(self::PROJET_3, $projet3);

        $projet4 = new Projet();
        $projet4
            ->setNom($faker->sentence())
            ->setArchive($faker->boolean())
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_3))
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_5));
        $manager->persist($projet4);
        $this->addReference(self::PROJET_4, $projet4);

        $projet5 = new Projet();
        $projet5
            ->setNom($faker->sentence())
            ->setArchive($faker->boolean());
        $manager->persist($projet5);
        $this->addReference(self::PROJET_5, $projet5);

        $projet6 = new Projet();
        $projet6
            ->setNom($faker->sentence())
            ->setArchive($faker->boolean())
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_4));
        $manager->persist($projet6);
        $this->addReference(self::PROJET_6, $projet6);

        $projet7 = new Projet();
        $projet7
            ->setNom($faker->sentence())
            ->setArchive($faker->boolean())
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_1))
            ->addEmploye($this->getReference(EmployeFixtures::EMPLOYE_2));
        $manager->persist($projet7);
        $this->addReference(self::PROJET_7, $projet7);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EmployeFixtures::class
        ];
    }
}
