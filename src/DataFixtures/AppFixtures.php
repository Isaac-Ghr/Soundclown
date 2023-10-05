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
        $genre = ["men", "women"];
        foreach ($lesArtistes as $var) {
            static $cpt = 1;
            $artiste = new Artiste();
            $artiste    -> setNom($var[1])
            -> setDescription($faker->paragraph()."|".$faker->paragraph())
            -> setSite("cestuneurl.com")
            -> setImage("https://randomuser.me/api/portraits/".$genre[$var[2]]."/".mt_rand(1,99).".jpg")
            -> setType($var[2]);
            $manager->persist($artiste);
            $this->addReference("artiste".$var[0], $artiste);
            $cpt++;
        }

        
        // Styles
        $lesStyles = fload("style.csv");
        foreach ($lesStyles as $vst) {
            static $cpt = 1;
            $style = new Style();
            $style      ->setLibelle($vst[1])
                        ->setCouleur($faker->safeHexColor());
            $manager->persist($style);
            $this->addReference("style".$vst[0], $style);
            $cpt++;
        }
        
        // Albums
        $lesAlbums = fload("album.csv");
        foreach ($lesAlbums as $val) {
            static $cpt = 1;
            $random = rand(0,300);
            $album = new Album();
            $album      -> setNom($val[1])
                        -> setDate(intval($val[2]))
                        -> setImage("https://picsum.photos/id/{$random}/200")
                        -> setArtiste($this->getReference("artiste".$val[4]))
                        -> addStyle($this->getReference("style".$val[3]));
            $manager->persist($album);
            $this->addReference("album".$val[0], $album);
            $cpt++;
        }

        //morceau
        $lesMorceau = fload("morceau.csv");
        foreach ($lesMorceau as $vmo) {
            static $cpt = 1;
            $morceau = new Morceau();
            $morceau    -> setTitre($vmo[2])
                        -> setDuree(date("i:s",$vmo[3]))
                        -> setAlbum($this->getReference("album".$vmo[1]));
            $manager->persist($morceau);
            $this->addReference("morceau".$vmo[0], $morceau);
            $cpt++;
        }
        
        $manager->flush();
    }
}
