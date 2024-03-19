<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NationaliteCreateTest extends WebTestCase
{
    public function testCreateNationalite(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_admin_nationalite_create'));
        $form = $crawler->filter('form[name=nationalite]')->form([
            'nationalite[libelle]' => 'testNatioAgain', // il faut changer ça à chaque test
            'nationalite[drapeau]' => 'https://urlTest.com'
        ]);

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();
        $this->assertRouteSame('app_admin_nationalite_liste');
    }

    public function testListNationalite(): void
    {
        $client = static::createClient();

        $urlGen = $client->getContainer()->get('router');

        $client->request(Request::METHOD_GET, $urlGen->generate('app_nationalite_liste'));
        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('app_nationalite_liste');
    }
}
