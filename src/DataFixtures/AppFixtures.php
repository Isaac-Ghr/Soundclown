<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Album;
use App\Entity\Label;
use App\Entity\Style;
use App\Entity\Artiste;
use App\Entity\Morceau;
use App\Entity\Nationalite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{    
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create("fr_FR");

        $label=new Label();
        $label  ->setNom("Warner Music Group")
                ->setDescription("<p>". join("</p><p>",$faker->paragraphs(5)) . "</p>")
                ->setAnnee(2004)
                ->setType("Majeur")
                ->setLogo("https://picsum.photos/100/100");
                $manager->persist($label);
                // $manager->flush();
                $this->addReference("label1", $label);

        $label=new Label();
        $label  ->setNom("Universal Music Group")
                ->setDescription("<p>". join("</p><p>",$faker->paragraphs(5)) . "</p>")
                ->setAnnee(1996)
                ->setType("Majeur")
                ->setLogo("https://picsum.photos/100/100");
                $manager->persist($label);
                // $manager->flush();
                $this->addReference("label2", $label);

        $label=new Label();
        $label  ->setNom("Polygram Music")
                ->setDescription("<p>". join("</p><p>",$faker->paragraphs(5)) . "</p>")
                ->setAnnee(1972)
                ->setType("Majeur")
                ->setLogo("https://picsum.photos/100/100");
                $manager->persist($label);
                // $manager->flush();
                $this->addReference("label3", $label);

        $label=new Label();
        $label  ->setNom("EMI Group")
                ->setDescription("<p>". join("</p><p>",$faker->paragraphs(5)) . "</p>")
                ->setAnnee(1931)
                ->setType("Majeur")
                ->setLogo("https://picsum.photos/100/100");
                $manager->persist($label);
                // $manager->flush();
                $this->addReference("label4", $label);

        $label=new Label();
        $label  ->setNom("Alligator")
                ->setDescription("<p>". join("</p><p>",$faker->paragraphs(5)) . "</p>")
                ->setAnnee(2020)
                ->setType("Indépendant")
                ->setLogo("https://picsum.photos/100/100");
                $manager->persist($label);
                // $manager->flush();
                $this->addReference("label5", $label);

        $label=new Label();
        $label  ->setNom("Alive Records")
                ->setDescription("<p>". join("</p><p>",$faker->paragraphs(5)) . "</p>")
                ->setAnnee(2015)
                ->setType("Indépendant")
                ->setLogo("https://picsum.photos/100/100");
                $manager->persist($label);
                // $manager->flush();
                $this->addReference("label6", $label);

        $label=new Label();
        $label  ->setNom("Alchemy Records")
                ->setDescription("<p>". join("</p><p>",$faker->paragraphs(5)) . "</p>")
                ->setAnnee(2018)
                ->setType("Indépendant")
                ->setLogo("https://picsum.photos/100/100");
                $manager->persist($label);
                // $manager->flush();
                $this->addReference("label7", $label);
        
        function fload(?String $file): array
        {
            $f = fopen(__DIR__."/".$file,'r');
            while (!feof($f)) {
                $resultat[] = fgetcsv($f);
            }
            fclose($f);
            return $resultat;
        }
        
        $natio = [
            "Française" => "https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%29.svg/langfr-225px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%29.svg.png",
            "Américaine" => "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Flag_of_the_United_States.svg/langfr-225px-Flag_of_the_United_States.svg.png"
        ];
        $cpt = 1;
        foreach ($natio as $nom => $drap) {
            $n = new Nationalite();
            $n->setLibelle($nom)->setDrapeau($drap);
            $manager->persist($n);
            $this->addReference("natio".$cpt, $n);
            $cpt++;
        }

        // Artistes
        $lesArtistes = fload("artiste.csv");
        $genre = ["men", "women"];
        $cpt = 1;
        foreach ($lesArtistes as $var) {
            $artiste = new Artiste();
            $artiste    -> setNom($var[1])
            -> setDescription($faker->paragraph())
            -> setSite("cestuneurl.com")
            -> setImage("https://randomuser.me/api/portraits/".$genre[mt_rand(1,99) % 2]."/".mt_rand(1,99).".jpg")
            -> setType($var[2])
            -> setNationalite($this->getReference("natio".mt_rand(1, 2)));
            $manager->persist($artiste);
            $this->addReference("artiste".$var[0], $artiste);
            $cpt++;
        }

        
        // Styles
        $lesStyles = fload("style.csv");
        $cpt = 1;
        foreach ($lesStyles as $vst) {
            $style = new Style();
            $style      ->setLibelle($vst[1])
                        ->setCouleur($faker->safeHexColor());
            $manager->persist($style);
            $this->addReference("style".$vst[0], $style);
            $cpt++;
        }
        
        // Albums
        $lesAlbums = fload("album.csv");
        $cpt = 1;
        foreach ($lesAlbums as $val) {
            $random = rand(0,300);
            $album = new Album();
            $album      -> setNom($val[1])
                        -> setDate(intval($val[2]))
                        -> setImage("https://picsum.photos/id/{$random}/200")
                        -> setArtiste($this->getReference("artiste".$val[4]))
                        -> addStyle($this->getReference("style".$val[3]))
                        ->setLabel($this->getReference("label".mt_rand(1,7)));
            $manager->persist($album);
            $this->addReference("album".$val[0], $album);
            $cpt++;
        }

        //morceau
        $lesMorceau = fload("morceau.csv");
        $cpt = 1;
        foreach ($lesMorceau as $vmo) {
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
