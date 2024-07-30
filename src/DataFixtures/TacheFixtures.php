<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Tache;
use \DateTime;
use \DateInterval;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class TacheFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        // Création des tâches
        $tache0 = new Tache();
        $tache0->setTitre('Développement de la structure globale')
            ->setDescription('Intégrer les maquettes')
            ->setStatut($this->getReference(StatutFixtures::STATUT_3))
            ->setEmploye($this->getReference(EmployeFixtures::EMPLOYE_2))
            ->setProjet($this->getReference(ProjetFixtures::PROJET_1))
            ->setDeadline((new DateTime())->sub(new DateInterval('P7D')));
        $manager->persist($tache0);

        $tache1 = new Tache();
        $tache1->setTitre('Développement de la page projet')
            ->setDescription('Page projet avec liste des tâches, édition, modification, suppression et création des tâches')
            ->setStatut($this->getReference(StatutFixtures::STATUT_3))
            ->setEmploye($this->getReference(EmployeFixtures::EMPLOYE_1))
            ->setProjet($this->getReference(ProjetFixtures::PROJET_1));
        $manager->persist($tache1);

        $tache2 = new Tache();
        $tache2->setTitre('Développement de la page employé')
            ->setDescription('Page employé avec liste des employés, édition, modification, suppression et création des employés')
            ->setStatut($this->getReference(StatutFixtures::STATUT_2))
            ->setEmploye($this->getReference(EmployeFixtures::EMPLOYE_2))
            ->setDeadline((new DateTime())->add(new DateInterval('P4D')))
            ->setProjet($this->getReference(ProjetFixtures::PROJET_1));
        $manager->persist($tache2);

        $tache3 = new Tache();
        $tache3->setTitre('Gestion des droits d\'accès')
            ->setDescription('Un employé ne peut accéder qu\'à ses projets')
            ->setStatut($this->getReference(StatutFixtures::STATUT_1))
            ->setDeadline((new DateTime())->add(new DateInterval('P12D')))
            ->setProjet($this->getReference(ProjetFixtures::PROJET_1));
        $manager->persist($tache3);

        $tache4 = new Tache();
        $tache4->setTitre('Déploiement sur l\'App Store')
            ->setDescription('Vérifier avant que tout fonctionne bien !')
            ->setStatut($this->getReference(StatutFixtures::STATUT_1))
            ->setProjet($this->getReference(ProjetFixtures::PROJET_2));
        $manager->persist($tache4);

        $tache5 = new Tache();
        $tache5->setTitre('Réalisation des maquettes')
            ->setDescription('À faire sur Figma')
            ->setStatut($this->getReference(StatutFixtures::STATUT_2))
            ->setEmploye($this->getReference(EmployeFixtures::EMPLOYE_3))
            ->setDeadline((new DateTime())->sub(new DateInterval('P18D')))
            ->setProjet($this->getReference(ProjetFixtures::PROJET_3));
        $manager->persist($tache5);

        $tache6 = new Tache();
        $tache6->setTitre('Intégration des maquettes')
            ->setDescription('Bien faire attention au responsive')
            ->setStatut($this->getReference(StatutFixtures::STATUT_1))
            ->setEmploye($this->getReference(EmployeFixtures::EMPLOYE_4))
            ->setProjet($this->getReference(ProjetFixtures::PROJET_3));
        $manager->persist($tache6);

        $tache7 = new Tache();
        $tache7->setTitre('Optimisation du référencement')
            ->setStatut($this->getReference(StatutFixtures::STATUT_1))
            ->setDeadline((new DateTime())->sub(new DateInterval('P35D')))
            ->setProjet($this->getReference(ProjetFixtures::PROJET_3));
        $manager->persist($tache7);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EmployeFixtures::class, StatutFixtures::class, ProjetFixtures::class
        ];
    }
}
