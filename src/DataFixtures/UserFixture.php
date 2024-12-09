<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('seb@lemagnifique.com');
        $admin->setName('Seb');
        $admin->setRoles(['ROLE_ADMIN']);

        // Hashage du mot de passe
        $hashedPassword = $this->hasher->hashPassword(
            $admin,
            'root'
        );
        $admin->setPassword($hashedPassword);

        $manager->persist($admin);
        $manager->flush();
    }
}