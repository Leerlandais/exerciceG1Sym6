<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setUsername('admin');
         $user->setUserMail('admin@gmail.com');
         $user->setRoles(['ROLE_ADMIN', 'ROLE_EDITOR', "ROLE_MANAGER"]);
         $user->setPassword($this->passwordEncoder->hashPassword($user, 'admin'));
         $user->setUserActive(true);
         $user->setUserRealName('The Admin !');

         $manager->persist($user);

         for($i = 1; $i <= 25; $i++){
        $user = new User();
        $user->setUsername('redac'.$i);
        $user->setUserMail('redac'.$i.'@gmail.com');
        $user->setRoles(['ROLE_EDITOR']);
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'redac'.$i));

              $user->setUserActive(rand(0,4));

        $user->setUserRealName('Redac'.$i." user");
        $manager->persist($user);
}
        for($i = 1; $i <= 5; $i++){
            $user = new User();
            $user->setUsername('manager'.$i);
            $user->setUserMail('manager'.$i.'@gmail.com');
            $user->setRoles(['ROLE_MANAGER', 'ROLE_EDITOR']);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'manager'.$i));

            $user->setUserActive(true);
            $user->setUserRealName('Redac'.$i." user");
            $manager->persist($user);
        }

        $manager->flush();
    }
}
