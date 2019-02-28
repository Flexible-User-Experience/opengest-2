<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Setting\User;
use AppBundle\Manager\RepositoriesManager;
use AppBundle\Service\FileService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class BaseAdmin.
 *
 * @category Admin
 */
abstract class AbstractBaseAdmin extends AbstractAdmin
{
    /**
     * @var UploaderHelper
     */
    private $vus;

    /**
     * @var CacheManager
     */
    private $lis;

    /**
     * @var RepositoriesManager
     */
    protected $rm;

    /**
     * @var FileService
     */
    protected $fs;

    /**
     * @var TwigEngine
     */
    private $tws;

    /**
     * @var TokenStorage
     */
    protected $ts;

    /**
     * @var AuthorizationChecker
     */
    protected $acs;

    /**
     * @var array
     */
    protected $perPageOptions = array(25, 50, 100, 200);

    /**
     * @var int
     */
    protected $maxPerPage = 25;

    /**
     * Methods.
     */

    /**
     * @param string               $code
     * @param string               $class
     * @param string               $baseControllerName
     * @param CacheManager         $lis
     * @param RepositoriesManager  $rm
     * @param FileService          $fs
     * @param TwigEngine           $tws
     * @param TokenStorage         $ts
     * @param AuthorizationChecker $acs
     */
    public function __construct($code, $class, $baseControllerName, CacheManager $lis, RepositoriesManager $rm, FileService $fs, TwigEngine $tws, TokenStorage $ts, AuthorizationChecker $acs)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->vus = $fs->getUhs();
        $this->lis = $lis;
        $this->rm = $rm;
        $this->fs = $fs;
        $this->tws = $tws;
        $this->ts = $ts;
        $this->acs = $acs;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('show')
            ->remove('batch')
        ;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    /**
     * @return array
     */
    public function getExportFormats()
    {
        return array(
            'csv',
            'xls',
        );
    }

    /**
     * @param string $bootstrapGrid
     * @param string $bootstrapSize
     * @param string $boxClass
     *
     * @return array
     */
    protected function getDefaultFormBoxArray($bootstrapGrid = 'md', $bootstrapSize = '6', $boxClass = 'primary')
    {
        return array(
            'class' => 'col-'.$bootstrapGrid.'-'.$bootstrapSize,
            'box_class' => 'box box-'.$boxClass,
        );
    }

    /**
     * @param string $bootstrapColSize
     *
     * @return array
     */
    protected function getFormMdSuccessBoxArray($bootstrapColSize = '6')
    {
        return $this->getDefaultFormBoxArray('md', $bootstrapColSize, 'success');
    }

    /**
     * Get image helper form mapper with thumbnail.
     *
     * @return string
     */
    protected function getMainImageHelperFormMapperWithThumbnail()
    {
        return ($this->getSubject() ? $this->getSubject()->getMainImage() ? '<img src="'.$this->lis->getBrowserPath(
                $this->vus->asset($this->getSubject(), 'mainImageFile'),
                '480xY'
            ).'" class="admin-preview img-responsive" alt="thumbnail"/>' : '' : '').'<p style="width:100%;display:block;margin-top:10px">* imatge amplada mínima 1.200 píxels<br>* arxiu pes màxim 10MB<br>* format JPG o PNG</p>';
    }

    /**
     * Get image helper form mapper with thumbnail.
     *
     * @return string
     */
    protected function getImageHelperFormMapperWithThumbnail()
    {
        return ($this->getSubject() ? $this->getSubject()->getImage() ? '<img src="'.$this->lis->getBrowserPath(
                $this->vus->asset($this->getSubject(), 'imageFile'),
                '480xY'
            ).'" class="admin-preview img-responsive" alt="thumbnail"/>' : '' : '').'<span style="width:100%;display:block;">amplada mínima 1200px (màx. 10MB amb JPG o PNG)</span>';
    }

    /**
     * Get image helper form mapper with thumbnail.
     *
     * @return string
     */
    protected function getLogoHelperFormMapperWithThumbnail()
    {
        return ($this->getSubject() ? $this->getSubject()->getLogo() ? '<img src="'.$this->lis->getBrowserPath(
                $this->vus->asset($this->getSubject(), 'logoFile'),
                '480xY'
            ).'" class="admin-preview img-responsive" alt="thumbnail"/>' : '' : '').'<span style="width:100%;display:block;">amplada mínima 300px (màx. 10MB amb JPG o PNG)</span>';
    }

    /**
     * Get image helper form mapper with thumbnail.
     *
     * @return string
     */
    protected function getProfileHelperFormMapperWithThumbnail()
    {
        return ($this->getSubject() ? $this->getSubject()->getProfilePhotoImage() ? '<img src="'.$this->lis->getBrowserPath(
                $this->vus->asset($this->getSubject(), 'profilePhotoImageFile'),
                '480xY'
            ).'" class="admin-preview img-responsive" alt="thumbnail"/>' : '' : '').'<span style="width:100%;display:block;">amplada mínima 300px (màx. 10MB amb JPG o PNG)</span>';
    }

    /**
     * Get image helper form mapper with thumbnail.
     *
     * @param string $attribute
     * @param string $uploaderMapping
     *
     * @return string
     *
     * @throws \Twig\Error\Error
     */
    protected function getSmartHelper($attribute, $uploaderMapping)
    {
        if ($this->getSubject() && $this->getSubject()->$attribute()) {
            if ($this->fs->isPdf($this->getSubject(), $uploaderMapping)) {
                // PDF case
                return $this->tws->render(':Admin/Helpers:pdf.html.twig', [
                    'attribute' => $this->getSubject()->$attribute(),
                    'subject' => $this->getSubject(),
                    'uploaderMapping' => $uploaderMapping,
                ]);
            } else {
                // Image case
                return $this->tws->render(':Admin/Helpers:image.html.twig', [
                    'attribute' => $this->getSubject()->$attribute(),
                    'subject' => $this->getSubject(),
                    'uploaderMapping' => $uploaderMapping,
                ]);
            }
        } else {
            // Undefined case
            return '<span style="width:100%;display:block;">Pots adjuntar un PDF o una imatge d\'una amplada mínima de 1200px. Pes màxim 10MB.</span>';
        }
    }

    /**
     * Get image helper form mapper with thumbnail for black&white.
     *
     * @return string
     */
    protected function getImageHelperFormMapperWithThumbnailBW()
    {
        return ($this->getSubject() ? $this->getSubject()->getImageNameBW() ? '<img src="'.$this->lis->getBrowserPath(
                $this->vus->asset($this->getSubject(), 'imageFileBW'),
                '480xY'
            ).'" class="admin-preview img-responsive" alt="thumbnail"/>' : '' : '').'<span style="width:100%;display:block;">amplada mínima 1200px (màx. 10MB amb JPG o PNG)</span>';
    }

    /**
     * @return string
     */
    protected function getImageHelperFormMapperWithThumbnailGif()
    {
        return ($this->getSubject() ? $this->getSubject()->getGifName() ? '<img src="'.$this->lis->getBrowserPath(
                $this->vus->asset($this->getSubject(), 'gifFile'),
                '480xY'
            ).'" class="admin-preview img-responsive" alt="thumbnail"/>' : '' : '').'<span style="width:100%;display:block;">mida 780x1168px (màx. 10MB amb GIF)</span>';
    }

    /**
     * @return string
     */
    protected function getDownloadPdfButton()
    {
        if ($this->getSubject() && !is_null($this->getSubject()->getAttatchmentPDF())) {
            $result = '<a class="btn btn-warning btn-xs" href="'.$this->vus->asset($this->getSubject(), 'attatchmentPDFFile').'" download="'.$this->getSubject()->getName().'.pdf"><i class="fa fa-file-pdf-o"></i> Document PDF</a>';

            return $result;
        }

        return '';
    }

    /**
     * @return string
     */
    protected function getDownloadDigitalTachographButton()
    {
        if ($this->getSubject() && !is_null($this->getSubject()->getUploadedFileName())) {
            $url = $this->routeGenerator->generateUrl($this, 'download', array('id' => $this->getSubject()->getId()));
            $result = '<a class="btn btn-warning" role="button" href="'.$url.'"><i class="fa fa-download"></i> Descarregar arxiu</a>';

            return $result;
        }

        return '';
    }

    /**
     * @return Enterprise
     */
    protected function getUserLogedEnterprise()
    {
        return $this->getUser()->getLoggedEnterprise();
    }

    /**
     * @return int
     */
    protected function getUserLogedId()
    {
        return $this->getUser()->getId();
    }

    /**
     * @return User|object
     */
    protected function getUser()
    {
        return $this->ts->getToken()->getUser();
    }
}
