<?php

namespace AppBundle\Admin;

/**
 * Class EnterpriseAdmin.
 *
 * @category    Admin
 * @auhtor      Wils Iglesias <wiglesias83@gmail.com>
 */
class EnterpriseAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Empresa';
    protected $baseRoutePattern = 'administracio/empresa';
    protected $datagridValues = array(
        '_sort_by' => 'name',
        '_sort_order' => 'asc',
    );
}
