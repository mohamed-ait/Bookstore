<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Autheur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public $autheur_ref= 'autheur';
        public $genre_ref = 'genre';
        public UserPasswordHasherInterface $passwordEncoder;

        //contructer
        public function __Construct(UserPasswordHasherInterface $passwordEncoder){
            $this->passwordEncoder=$passwordEncoder;
        }
        
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        //create 20 autheur
        for($i=0;$i<20;$i++){
            $autheur =new Autheur();
            $autheur->setNomPrenom($faker->firstName.' '.$faker->lastName);
            $autheur->setSexe($faker->RandomElement(['F','M']));
            $autheur->setDateDeNaissance(new \DateTime($faker->date()));
            $autheur->setNationalite($faker->CountryCode);
            $manager->persist($autheur);
            $this->addReference($this->autheur_ref . '-' . $i , $autheur);

        }
        // create 10 genre
        for($i=0;$i<10;$i++){
          $genre = new Genre();
          $genre->setNom($faker->word());
          $manager->persist($genre);
          $this->addReference($this->genre_ref . '-'  . $i,$genre);
        }
        //create 50 livres
        for($i=0;$i<50;$i++){
            $livre =new Livre();
            $livre->setIsbn($faker->isbn13);
            $livre->setTitre($faker->words($faker->numberBetween(1,3),true));
            $livre->setNombrePages($faker->numberBetween(15,600),true);
            $livre->setDateDeParution(new \DateTime($faker->dateTimeBetween('01-01-1900','01-01-2022')->format("Y-m-d")));
            $livre->setNote($faker->numberBetween(0,20));
            for($j=0;$j<$faker->numberBetween(1,3);$j++){
                $livre->addAutheur($this->getReference($this->autheur_ref.'-'. $faker->numberBetween(0,19)));
                $livre->addGenre($this->getReference($this->genre_ref.'-'. $faker->numberBetween(0,9)));
            }
            $manager->persist($livre);
        }
         $admin = new User();
         $admin->setEmail('admin@gmail.com');
         $admin->setPassword($this->passwordEncoder->hashPassword($admin,'123456789'));
         $admin->setRoles(['ROLE_ADMIN']);
         $manager->persist($admin);
        $manager->flush();
    }
}
