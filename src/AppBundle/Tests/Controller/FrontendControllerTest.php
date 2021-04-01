<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class FrontendControllerTest extends WebTestCase
{
    /**
     * Test HTTP request is successful.
     *
     * @dataProvider provideSuccessfulUrls
     *
     * @param string $url
     */
    public function testPagesAreSuccessful($url): void
    {
        $client = self::createClient();
        $client->request('GET', $url);

        self::assertStatusCode(200, $client);
    }

    /**
     * Successful Urls provider.
     *
     * @return array
     */
    public function provideSuccessfulUrls(): array
    {
        return array(
            array('/'),
            array('/servicio/my-title'),
            array('/empresa'),
            array('/vehiculo/my-vehicle-category/my-title'),
            array('/vehiculos/categoria/grues2'),
            array('/trabajos'),
            array('/trabajo/my-title'),
            array('/accesorios'),
            array('/accesorio/my-title'),
            array('/sobre-este-sitio'),
            array('/privacidad'),
            array('/mapa-del-web'),
            array('/sitemap/sitemap.default.xml'),
        );
    }

    /**
     * Test HTTP request is not found.
     *
     * @dataProvider provideNotFoundUrls
     *
     * @param string $url
     */
    public function testPagesAreNotFound($url): void
    {
        $client = self::createClient();         // anonymous user
        $client->request('GET', $url);

        self::assertStatusCode(404, $client);
    }

    /**
     * Not found Urls provider.
     *
     * @return array
     */
    public function provideNotFoundUrls(): array
    {
        return array(
            array('/ca/pagina-trenacada'),
            array('/es/pagina-rota'),
            array('/en/broken-page'),
        );
    }

    /**
     * Test HTTP request is redirected.
     *
     * @dataProvider provideRedirectedUrls
     *
     * @param string $url
     */
    public function testFrontendPagesAreRedirected($url): void
    {
        $client = self::createClient();           // anonymous user
        $client->request('GET', $url);

        self::assertStatusCode(302, $client);
    }

    /**
     * Urls provider.
     *
     * @return array
     */
    public function provideRedirectedUrls(): array
    {
        return array(
            array('/servicios'),
            array('/vehiculos'),
        );
    }
}
