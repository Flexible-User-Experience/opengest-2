<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            // Doctrine
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            // SensioLabs
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            // Sonata
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            // Vendors
            new FOS\UserBundle\FOSUserBundle(),
            new Hautelook\AliceBundle\HautelookAliceBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            // App
            new AppBundle\AppBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Liip\FunctionalTestBundle\LiipFunctionalTestBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
