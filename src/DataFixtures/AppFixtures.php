<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setName('Mathis');
        $user->setLastName('VIAL');
        $user->setUsername('Serpa');
        $password = $this->hasher->hashPassword($user, 'mv281202');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail('mathis.vial@bbox.fr');

        $manager->persist($user);
        $manager->flush();
    }
}
