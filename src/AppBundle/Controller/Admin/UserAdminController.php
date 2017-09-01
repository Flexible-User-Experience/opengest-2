<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\ContactMessage;
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
     * @param int|string|null $id
     * @param Request         $request
     *
     * @return Response
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function profileAction($id = null, Request $request = null)
    {
        $request = $this->resolveRequest($request);
        $id = $request->get($this->admin->getIdParameter());

        /** @var ContactMessage $object */
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $object->setChecked(true);
        $this->admin->checkAccess('show', $object);

        $preResponse = $this->preShow($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->render(
            $this->admin->getTemplate('show'),
            array(
                'action' => 'show',
                'object' => $object,
                'elements' => $this->admin->getShow(),
            )
        );
    }
}
