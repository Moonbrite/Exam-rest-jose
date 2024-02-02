<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class EmployeFixtures extends Fixture
{

    private $hash;

    public function __construct(UserPasswordHasherInterface $hash){
        $this->hash = $hash;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr-Fr');

        for ($i =0; $i< 101;$i++){
            $employe = new Employe();
            $employe->setNom($faker->name);
            $employe->setPrenom($faker->firstName);
            $employe->setUsername($faker->userName);
            $employe->setPassword($this->hash->hashPassword($employe,$faker->password(8,15)));
            $employe->setRoles([]);
            $manager->persist($employe);
        }

        $employeUser = new Employe();
        $employeUser->setNom("user");
        $employeUser->setPrenom("user");
        $employeUser->setUsername("user");
        $employeUser->setPassword($this->hash->hashPassword($employeUser,"user"));
        $employeUser->setRoles([]);
        $manager->persist($employeUser);


        $employeAdmin = new Employe();
        $employeAdmin->setNom("admin");
        $employeAdmin->setPrenom("admin");
        $employeAdmin->setUsername("admin");
        $employeAdmin->setPassword($this->hash->hashPassword($employeAdmin,"admin"));
        $employeAdmin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($employeAdmin);

        $manager->flush();
    }
}
