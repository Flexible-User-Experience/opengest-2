<?php

namespace AppBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class abstract base test.
 *
 * @category Test
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
abstract class AbstractBaseTest extends WebTestCase
{
    /**
     * Set up test.
     */
    public function setUp()
    {
        $this->runCommand('hautelook_alice:doctrine:fixtures:load');
    }
}
