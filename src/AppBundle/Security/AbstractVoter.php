<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class AbstractVoter.
 */
abstract class AbstractVoter extends Voter
{
    public const EDIT = 'edit';

    public const ATTRIBUTES = [
        self::EDIT,
    ];
}
