<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Nationalite;

class NationaliteTest extends KernelTestCase
{
    public function testValidEntity(): void
    {
        $natio = (new Nationalite())->setLibelle("test")
        ->setDrapeau("https://commons.wikimedia.org/w/index.php?title=File:Flag_of_France_(1794%E2%80%931815,_1830%E2%80%931974).svg&lang=fr&uselang=fr");
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($natio);
        $this->assertCount(0, $error);
    }
}
