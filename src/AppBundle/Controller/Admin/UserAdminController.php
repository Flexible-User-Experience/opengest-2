<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\UserDefaultEnterpriseForm;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserAdminController.
 *
 * @category Controller
 *
 * @author   David Romaní <david@flux.cat>
 */
class UserAdminController extends BaseAdminController
{
    /**
     * Profile action.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function profileAction(Request $request = null)
    {
        $request = $this->resolveRequest($request);

        /** @var User $object */
        $object = $this->getUser();

        $form = $this->createForm(UserDefaultEnterpriseForm::class, $object);
        $form->handleRequest($request);

        return $this->render(
            '::Admin/User/profile.html.twig',
            array(
                'action' => 'show',
                'object' => $object,
                'elements' => $this->admin->getShow(),
                'profileForm' => $form->createView(),
            )
        );
    }
}
