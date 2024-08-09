<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\ProjetRepository;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProjetVoter extends Voter
{    
    public function __construct(
        private ProjetRepository $projetRepository,
        private AuthorizationCheckerInterface $authorizationChecker
    )
    {    
        $this->projetRepository = $projetRepository;
        $this->authorizationChecker = $authorizationChecker;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === 'acces_projet';
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // si l'utilisateur n'est pas authentifié, c'est non!
        if (!$user instanceof UserInterface) {
            return false;
        }

        if($attribute === 'acces_projet') {
            $projet = $this->projetRepository->find($subject);

            // l'utilisateur est un administrateur
            if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                return true;
            }

            // Vérifier si l'utilisateur est associé au projet
            return $projet->getEmployes()->contains($user);
        }

        return false;
    }
}