<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Employe;
use \DateTime;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class EmployeFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $encoder
    )
    {
    }

    public const EMPLOYE_1 = 'employe 1';
    public const EMPLOYE_2 = 'employe 2';
    public const EMPLOYE_3 = 'employe 3';
    public const EMPLOYE_4 = 'employe 4';
    public const EMPLOYE_5 = 'employe 5';

    public function load(ObjectManager $manager): void
    {        
        $faker = (new \Faker\Factory())::create('fr_FR');
        $contract = ['CDI', 'CDD', 'Freelance', 'Alternance', 'Stagiaire'];

        // Création des employés
        $employe1 = new Employe();
        $employe1->setNom('Dillon')
            ->setPrenom('Natalie')
            ->setEmail('natalie@driblet.com')
            ->setStatut('CDI')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->hashPassword($employe1, '123456'))
            ->setDateArrivee(new DateTime('2019-06-14'));
        $manager->persist($employe1);
        $this->addReference(self::EMPLOYE_1, $employe1);

        $employe2 = new Employe();
        $employe2->setNom('Orden')
            ->setPrenom('Laurent')
            ->setEmail('orden@gmail.com')
            ->setStatut('CDI')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->hashPassword($employe2, 'Motdepasse'))
            ->setDateArrivee(new DateTime('2022-07-02'));
        $manager->persist($employe2);
        $this->addReference(self::EMPLOYE_2, $employe2);

        $employe3 = new Employe();
        $employe3->setNom($faker->lastName())
            ->setPrenom($faker->firstName())
            ->setEmail($faker->freeEmail())
            ->setRoles(["ROLE_USER"])
            ->setPassword($this->encoder->hashPassword($employe3, $employe3->getPrenom()))
            ->setStatut($contract[mt_rand(0,4)])
            ->setDateArrivee(new DateTime('now +' . mt_rand(1,20). ' day'));
        $manager->persist($employe3);
        $this->addReference(self::EMPLOYE_3, $employe3);

        $employe4 = new Employe();
        $employe4->setNom($faker->lastName())
            ->setPrenom($faker->firstName())
            ->setEmail($faker->freeEmail())
            ->setRoles(["ROLE_USER"])
            ->setPassword($this->encoder->hashPassword($employe4, $employe4->getPrenom()))
            ->setStatut($contract[mt_rand(0,4)])
            ->setDateArrivee(new DateTime('now +' . mt_rand(1,20). ' day'));
        $manager->persist($employe4);
        $this->addReference(self::EMPLOYE_4, $employe4);

        $employe5 = new Employe();
        $employe5->setNom($faker->lastName())
            ->setPrenom($faker->firstName())
            ->setEmail($faker->freeEmail())
            ->setRoles(["ROLE_USER"])
            ->setPassword($this->encoder->hashPassword($employe5, $employe5->getPrenom()))
            ->setStatut($contract[mt_rand(0,4)])
            ->setDateArrivee(new DateTime('now +' . mt_rand(1,20). ' day'));
        $manager->persist($employe5);
        $this->addReference(self::EMPLOYE_5, $employe5);

        $manager->flush();
    }
}
