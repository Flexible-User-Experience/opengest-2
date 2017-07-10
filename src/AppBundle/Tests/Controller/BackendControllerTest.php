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
            array('/admin/dashboard'),
            array('/admin/web/servei/list'),
            array('/admin/web/servei/create'),
            array('/admin/web/servei/1/edit'),
            array('/admin/web/servei/1/delete'),
            array('/admin/web/treball/list'),
            array('/admin/web/treball/create'),
            array('/admin/web/treball/1/edit'),
            array('/admin/web/treball/1/delete'),
            array('/admin/web/imatge-treball/list'),
            array('/admin/web/imatge-treball/create'),
            array('/admin/web/imatge-treball/1/edit'),
            array('/admin/web/imatge-treball/1/delete'),
            array('/admin/web/categoria-vehicle/list'),
            array('/admin/web/categoria-vehicle/create'),
            array('/admin/web/categoria-vehicle/1/edit'),
            array('/admin/web/categoria-vehicle/1/delete'),
            array('/admin/web/vehicle/list'),
            array('/admin/web/vehicle/create'),
            array('/admin/web/vehicle/1/edit'),
            array('/admin/web/vehicle/1/delete'),
            array('/admin/web/accesori/list'),
            array('/admin/web/accesori/create'),
            array('/admin/web/accesori/1/edit'),
            array('/admin/contact/message/list'),
            array('/admin/contact/message/1/show'),
            array('/admin/contact/message/1/answer'),
            array('/admin/users/list'),
            array('/admin/users/create'),
            array('/admin/users/1/edit'),
            array('/admin/users/1/delete'),
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
            array('/admin/web/servei/1/show'),
            array('/admin/web/servei/batch'),
            array('/admin/web/accesorio/1/delete'),
            array('/admin/users/show'),
            array('/admin/users/batch'),
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
