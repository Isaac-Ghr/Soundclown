<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Artiste;
use App\Entity\Album;
use App\Entity\Morceau;
use App\Entity\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        
        function fload(?String $file): array
        {
            $f = fopen(__DIR__."/".$file,'r');
            while (!feof($f)) {
                $resultat[] = fgetcsv($f);
            }
            fclose($f);
            return $resultat;
        }
        
        // Artistes
        $lesArtistes = fload("artiste.csv");
        $genre = ["man", "woman"];
        foreach ($lesArtistes as $var) {
            $artiste = new Artiste();
            $artiste    -> setNom($var[1])
                        -> setDescription("<p>partez du principe que c'est un long paragraphe</p><p>cette ligne de caractères est aussi un paragraphe</p>")
                        -> setSite("cestuneurl.com")
                        -> setImage("https://randomuser.me/api/portraits/".$genre[mt_rand(0,1)]."/".mt_rand(1,99).".jpg")
                        -> setType($var[2]);
            $manager->persist($artiste);
            $this->addReference("artiste".$artiste->getId(), $artiste);
        }

        // Styles
        $lesStyles = fload("style.csv");
        foreach ($lesStyles as $vst) {
            $style = new Style();
            $style      ->setLibelle($vst[1])
                        ->setCouleur($faker->safeHexColor());
            $manager->persist($style);
            $this.addReference("style".$style->getId(), $style);
        }

        // Albums
        $lesAlbums = fload("album.csv");
        foreach ($lesAlbums as $val) {
            $album = new Album();
            $album      -> setNom($val[1])
                        -> setDate(intval($val[2]))
                        -> setArtiste($this->getReference("artiste".$val[4]));
            $manager->persist($album);
            $this.addReference("album".$album->getId(), $album);
        }

        //morceau
        $lesMorceau = fload("morceau.csv");
        foreach ($lesMorceau as $vmo) {
            $morceau = new Morceau();
            $morceau    -> setTitre($vmo[2])
                        -> setDuree(date("i:s",$vmo[3]))
                        -> setArtiste($this->getReference("artiste".$vmo[4]));
            $manager->persist($morceau);
            $this.addReference("morceau".$morceau->getId(), $morceau);
        }

        $manager->flush();
    }
}
