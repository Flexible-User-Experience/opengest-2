<?php

namespace AppBundle\Admin;

use AppBundle\Manager\RepositoriesManager;
use AppBundle\Service\FileService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class BaseAdmin.
 *
 * @category Admin
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
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
     * @param string              $code
     * @param string              $class
     * @param string              $baseControllerName
     * @param CacheManager        $lis
     * @param RepositoriesManager $rm
     * @param FileService         $fs
     * @param TwigEngine          $tws
     */
    public function __construct($code, $class, $baseControllerName, CacheManager $lis, RepositoriesManager $rm, FileService $fs, TwigEngine $tws)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->vus = $fs->getUhs();
        $this->lis = $lis;
        $this->rm = $rm;
        $this->fs = $fs;
        $this->tws = $tws;
    }

    /**
     * @var array
     */
    protected $perPageOptions = array(25, 50, 100, 200);

    /**
     * @var int
     */
    protected $maxPerPage = 25;

    /**
     * Configure route collection.
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('show')
//            ->remove('delete')
            ->remove('batch');
    }

    /**
     * Remove batch action list view first column.
     *
     * @return array
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    /**
     * Get export formats.
     *
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
            ).'" class="admin-preview img-responsive" alt="thumbnail"/>' : '' : '').'<span style="width:100%;display:block;">amplada mínima 1200px (màx. 10MB amb JPG o PNG)</span>';
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
}
