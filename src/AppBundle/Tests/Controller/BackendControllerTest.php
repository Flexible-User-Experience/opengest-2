<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\AbstractBaseTest;

/**
 * Class BackendControllerTest.
 *
 * @category Test
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class BackendControllerTest extends AbstractBaseTest
{
    /**
     * Test admin login request is successful.
     */
    public function testAdminLoginPageIsSuccessful()
    {
        $client = $this->createClient();           // anonymous user
        $client->request('GET', '/admin/login');

        $this->assertStatusCode(200, $client);
    }

    /**
     * Test HTTP request is successful.
     *
     * @dataProvider provideSuccessfulUrls
     *
     * @param string $url
     */
    public function testAdminPagesAreSuccessful($url)
    {
        $client = $this->makeClient(true);         // authenticated user
        $client->request('GET', $url);

        $this->assertStatusCode(200, $client);
    }

    /**
     * Successful Urls provider.
     *
     * @return array
     */
    public function provideSuccessfulUrls()
    {
        return array(
            // Web
            array('/admin/dashboard'),
            array('/admin/web/servei/list'),
            array('/admin/web/servei/create'),
            array('/admin/web/servei/1/edit'),
            array('/admin/web/treball/list'),
            array('/admin/web/treball/create'),
            array('/admin/web/treball/1/edit'),
            array('/admin/web/imatge-treball/list'),
            array('/admin/web/imatge-treball/create'),
            array('/admin/web/imatge-treball/1/edit'),
            array('/admin/web/imatge-treball/1/delete'),
            array('/admin/web/categoria-vehicle/list'),
            array('/admin/web/categoria-vehicle/create'),
            array('/admin/web/categoria-vehicle/1/edit'),
            array('/admin/web/accesori/list'),
            array('/admin/web/accesori/create'),
            array('/admin/web/accesori/1/edit'),
            // Administration
            array('/admin/administracio/provincia/list'),
            array('/admin/administracio/provincia/create'),
            array('/admin/administracio/provincia/1/edit'),
            array('/admin/administracio/ciutat/list'),
            array('/admin/administracio/ciutat/create'),
            array('/admin/administracio/ciutat/1/edit'),
            array('/admin/administracio/usuari/list'),
            array('/admin/administracio/usuari/create'),
            array('/admin/administracio/usuari/1/edit'),
            array('/admin/administracio/usuari/1/delete'),
            array('/admin/administracio/series-factura/1/edit'),
            array('/admin/administracio/series-factura/1/delete'),
            // Operators
            array('/admin/operaris/operador/list'),
            array('/admin/operaris/operador/create'),
            array('/admin/operaris/operador/1/edit'),
            array('/admin/operaris/tipus-revisio/list'),
            array('/admin/operaris/tipus-revisio/create'),
            array('/admin/operaris/tipus-revisio/1/edit'),
            array('/admin/operaris/revisio/list'),
            array('/admin/operaris/revisio/create'),
            array('/admin/operaris/revisio/1/edit'),
            array('/admin/operaris/tipus-absencia/list'),
            array('/admin/operaris/tipus-absencia/create'),
            array('/admin/operaris/tipus-absencia/1/edit'),
            array('/admin/operaris/absencia/list'),
            array('/admin/operaris/absencia/create'),
            array('/admin/operaris/absencia/1/edit'),
            array('/admin/operaris/tacograf/list'),
            array('/admin/operaris/tacograf/create'),
            array('/admin/operaris/tacograf/1/edit'),
            array('/admin/operaris/imports-varis/list'),
            array('/admin/operaris/imports-varis/create'),
            array('/admin/operaris/imports-varis/1/edit'),
            // Vehicles
            array('/admin/vehicles/vehicle/list'),
            array('/admin/vehicles/vehicle/create'),
            array('/admin/vehicles/vehicle/1/edit'),
            array('/admin/vehicles/tacograf/list'),
            array('/admin/vehicles/tacograf/create'),
            array('/admin/vehicles/tacograf/1/edit'),
            // Contacts
            array('/admin/contactes/missatge-contacte/list'),
            array('/admin/contactes/missatge-contacte/1/show'),
            array('/admin/contactes/missatge-contacte/1/answer'),
            // Enterprises
            array('/admin/empreses/empresa/list'),
            array('/admin/empreses/empresa/create'),
            array('/admin/empreses/empresa/1/edit'),
            array('/admin/empreses/grup-prima/list'),
            array('/admin/empreses/grup-prima/create'),
            array('/admin/empreses/grup-prima/1/edit'),
            array('/admin/empreses/grup-prima/1/delete'),
            array('/admin/empreses/compte-bancari/create'),
            array('/admin/empreses/compte-bancari/1/edit'),
            array('/admin/empreses/compte-bancari/1/delete'),
            array('/admin/empreses/dies-festius/create'),
            array('/admin/empreses/dies-festius/1/edit'),
            array('/admin/empreses/dies-festius/1/delete'),
            array('/admin/empreses/linies-activitat/create'),
            array('/admin/empreses/linies-activitat/1/edit'),
            array('/admin/empreses/linies-activitat/1/delete'),
            array('/admin/empreses/tipus-document-cobrament/create'),
            array('/admin/empreses/tipus-document-cobrament/1/edit'),
            array('/admin/empreses/tipus-document-cobrament/1/delete'),
            // Partners
            array('/admin/tercers/classe/create'),
            array('/admin/tercers/classe/1/edit'),
            array('/admin/tercers/classe/1/delete'),
            array('/admin/tercers/tipus/create'),
            array('/admin/tercers/tipus/1/edit'),
            array('/admin/tercers/tipus/1/delete'),
            array('/admin/tercers/tercer/create'),
            array('/admin/tercers/tercer/1/edit'),
            array('/admin/tercers/tercer/1/delete'),
            array('/admin/tercers/comandes/create'),
            array('/admin/tercers/comandes/1/edit'),
            array('/admin/tercers/comandes/1/delete'),
            array('/admin/tercers/obres/create'),
            array('/admin/tercers/obres/1/edit'),
            array('/admin/tercers/obres/1/delete'),
            array('/admin/tercers/contacte/create'),
            array('/admin/tercers/contacte/1/edit'),
            array('/admin/tercers/contacte/1/delete'),
            array('/admin/tercers/dies-inhabils/list'),
            array('/admin/tercers/dies-inhabils/create'),
            array('/admin/tercers/dies-inhabils/1/edit'),
            array('/admin/tercers/dies-inhabils/1/delete'),
            // Sale
            array('/admin/vendes/tarifa/create'),
            array('/admin/vendes/tarifa/1/edit'),
            array('/admin/vendes/tarifa/1/delete'),
            array('/admin/vendes/peticio/create'),
            array('/admin/vendes/peticio/1/edit'),
            array('/admin/vendes/peticio/1/delete'),
            array('/admin/vendes/albara/create'),
            array('/admin/vendes/albara/1/edit'),
            array('/admin/vendes/albara/1/delete'),
            array('/admin/vendes/albara-linia/create'),
            array('/admin/vendes/albara-linia/1/edit'),
            array('/admin/vendes/albara-linia/1/delete'),
            array('/admin/vendes/factura/create'),
            array('/admin/vendes/factura/1/edit'),
            array('/admin/vendes/factura/1/delete'),
        );
    }

    /**
     * Test HTTP request is not found.
     *
     * @dataProvider provideNotFoundUrls
     *
     * @param string $url
     */
    public function testAdminPagesAreNotFound($url)
    {
        $client = $this->makeClient(true);         // authenticated user
        $client->request('GET', $url);

        $this->assertStatusCode(404, $client);
    }

    /**
     * Not found Urls provider.
     *
     * @return array
     */
    public function provideNotFoundUrls()
    {
        return array(
            // Web
            array('/admin/web/servei/1/show'),
            array('/admin/web/servei/batch'),
            array('/admin/web/servei/1/delete'),
            array('/admin/web/treball/1/show'),
            array('/admin/web/treball/batch'),
            array('/admin/web/treball/1/delete'),
            array('/admin/web/categoria-vehicle/1/show'),
            array('/admin/web/categoria-vehicle/batch'),
            array('/admin/web/categoria-vehicle/1/delete'),
            array('/admin/web/vehicle/1/show'),
            array('/admin/web/vehicle/batch'),
            array('/admin/web/vehicle/1/delete'),
            array('/admin/web/accesori/1/show'),
            array('/admin/web/accesori/batch'),
            array('/admin/web/accesori/1/delete'),
            // Administrator
            array('/admin/administracio/provincia/1/show'),
            array('/admin/administracio/provincia/batch'),
            array('/admin/administracio/provincia/1/delete'),
            array('/admin/administracio/ciutat/1/show'),
            array('/admin/administracio/ciutat/batch'),
            array('/admin/administracio/ciutat/1/delete'),
            array('/admin/administracio/usuari/1/show'),
            array('/admin/administracio/usuari/batch'),
            array('/admin/administracio/series-factura/1/show'),
            array('/admin/administracio/series-factura/batch'),
            // Operators
            array('/admin/operaris/operador/1/delete'),
            array('/admin/operaris/operador/1/show'),
            array('/admin/operaris/operador/batch'),
            array('/admin/operaris/tipus-revisio/1/delete'),
            array('/admin/operaris/tipus-revisio/1/show'),
            array('/admin/operaris/tipus-revisio/batch'),
            array('/admin/operaris/revisio/1/delete'),
            array('/admin/operaris/revisio/1/show'),
            array('/admin/operaris/revisio/batch'),
            array('/admin/operaris/tipus-absencia/1/delete'),
            array('/admin/operaris/tipus-absencia/1/show'),
            array('/admin/operaris/tipus-absencia/batch'),
            array('/admin/operaris/absencia/1/delete'),
            array('/admin/operaris/absencia/1/show'),
            array('/admin/operaris/absencia/batch'),
            array('/admin/operaris/tacograf/1/delete'),
            array('/admin/operaris/tacograf/1/show'),
            array('/admin/operaris/tacograf/batch'),
            array('/admin/operaris/imports-varis/1/show'),
            array('/admin/operaris/imports-varis/batch'),
            // Vehicles
            array('/admin/vehicles/tacograf/delete'),
            array('/admin/vehicles/tacograf/show'),
            array('/admin/vehicles/tacograf/1/batch'),
            // Contacts
            array('/admin/contactes/missatge-contacte/create'),
            array('/admin/contactes/missatge-contacte/1/edit'),
            array('/admin/contactes/missatge-contacte/1/delete'),
            // Enterprises
            array('/admin/empreses/empresa/1/show'),
            array('/admin/empreses/empresa/batch'),
            array('/admin/empreses/empresa/1/delete'),
            array('/admin/empreses/grup-prima/1/show'),
            array('/admin/empreses/grup-prima/batch'),
            array('/admin/empreses/compte-bancari/1/show'),
            array('/admin/empreses/compte-bancari/batch'),
            array('/admin/empreses/dies-festius/1/show'),
            array('/admin/empreses/dies-festius/batch'),
            array('/admin/empreses/linies-activitat/1/show'),
            array('/admin/empreses/linies-activitat/batch'),
            array('/admin/empreses/tipus-document-cobrament/1/show'),
            array('/admin/empreses/tipus-document-cobrament/batch'),
            // Partners
            array('/admin/tercers/classe/1/show'),
            array('/admin/tercers/classe/batch'),
            array('/admin/tercers/tipus/1/show'),
            array('/admin/tercers/tipus/batch'),
            array('/admin/tercers/tercer/1/show'),
            array('/admin/tercers/tercer/batch'),
            array('/admin/tercers/comandes/1/show'),
            array('/admin/tercers/comandes/batch'),
            array('/admin/tercers/obres/1/show'),
            array('/admin/tercers/obres/batch'),
            array('/admin/tercers/contacte/1/show'),
            array('/admin/tercers/contacte/batch'),
            array('/admin/tercers/dies-inhabils/1/show'),
            array('/admin/tercers/dies-inhabils/batch'),
            // Sale
            array('/admin/vendes/tarifa/1/show'),
            array('/admin/vendes/tarifa/batch'),
            array('/admin/vendes/peticio/1/show'),
            array('/admin/vendes/peticio/batch'),
            array('/admin/vendes/albara/1/show'),
            array('/admin/vendes/albara/batch'),
            array('/admin/vendes/albara-linia/1/show'),
            array('/admin/vendes/albara-linia/batch'),
            array('/admin/vendes/factura/1/show'),
            array('/admin/vendes/factura/batch'),
        );
    }

    /**
     * Test HTTP request is redirection.
     *
     * @dataProvider provideRedirectionUrls
     *
     * @param string $url
     */
//    public function testAdminPagesAreRedirection($url)
//    {
//        $client = $this->makeClient(true);         // authenticated user
//        $client->request('GET', $url);
//
//        $this->assertStatusCode(302, $client);
//    }

    /**
     * Not found Urls provider.
     *
     * @return array
     */
    public function provideRedirectionUrls()
    {
        return array(
//            array('/admin/coworkers/coworker/1/show'),
//            array('/admin/activitats/activitat/1/show'),
//            array('/admin/web/post/1/show'),
        );
    }
}
