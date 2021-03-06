<?php

namespace AppBundle\Controller\Admin\Setting;

use AppBundle\Controller\Admin\BaseAdminController;
use AppBundle\Entity\Setting\User;
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
        if ($form->isSubmitted() && $form->isValid()) {
            // update database
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            // build flash message
            $this->addFlash('success', 'El teu perfil s\'ha actualizat correctament.');

            return $this->redirectToRoute('sonata_admin_dashboard');
        }

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
