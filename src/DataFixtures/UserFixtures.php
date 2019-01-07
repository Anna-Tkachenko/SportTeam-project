<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user
                ->setUsername($faker->userName)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPassword($this->passwordEncoder->encodePassword($user, $faker->password))
                ->setEmail($faker->email)
                ->setIsActive($faker->boolean(50))
                ->setImage($faker->imageUrl());

            $manager->persist($user);
        }
        $manager->flush();
    }
}
