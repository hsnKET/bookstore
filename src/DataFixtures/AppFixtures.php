<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $genres = [];
        for ($i = 0; $i < 10; $i++) {
            $genre = new Genre();
            $genre->setNom($faker->name());
            $manager->persist($genre);
            $genres[] = $genre;
        }
        $manager->flush();
        $auteurs = [];
        for ($j = 0; $j < 20; $j++) {
            $auteur = new Auteur();
            $auteur->setNomPrenom($faker->name());
            $auteur->setSexe(($faker->randomDigit % 2 == 0) ? 'F' : 'M');
            $date = DateTimeImmutable::createFromMutable($faker->dateTime());
            $auteur->setDateDeNaissance($date);
            $auteur->setNationalite($faker->countryCode);
            $manager->persist($auteur);
            $auteurs[] = $auteur;
        }
        $manager->flush();

        for ($k = 0; $k < 50; $k++) {
            $livre = new Livre();
            $livre->setIsbn($faker->isbn13);
            $livre->setTitre($faker->text(18));
            $livre->setNombrePages($faker->randomDigit);
            $date = DateTimeImmutable::createFromMutable($faker->dateTime());
            $livre->setDateDeParution($date);
            $livre->setNote($faker->randomDigit);
            $livre->setImage($faker->imageUrl(640, 480));
            $livre->setDescription($faker->paragraph(3));
            $livre->addGenre($genres[$faker->numberBetween(0, count($genres) - 1)]);
            $livre->addAuteur($auteurs[$faker->numberBetween(0, count($auteurs) - 1)]);
            $manager->persist($livre);
        }
        $manager->flush();
    }
}
