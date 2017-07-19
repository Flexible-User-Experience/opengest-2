<?php

namespace AppBundle\Service;

use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class FileService.
 *
 * @category Service
 *
 * @author   David Romaní <david@flux.cat>
 */
class FileService
{
    /**
     * @var UploaderHelper
     */
    private $uhs;

    /**
     * Methods.
     *
     * @param UploaderHelper $uhs
     */
    public function __construct(UploaderHelper $uhs)
    {
        $this->uhs = $uhs;
    }

    /**
     * @param mixed  $entity
     * @param string $attribute
     *
     * @return string
     */
    public function getMimeType($entity, $attribute)
    {
        $path = $this->uhs->asset($entity, $attribute);

        return $path;
    }
}
