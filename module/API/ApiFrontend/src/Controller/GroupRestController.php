<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 20:37
 */

namespace API\ApiFrontend\Controller;


use API\LdapGroupModel\Entity\LdapGroupEntity;
use API\LdapGroupModel\Hydrator\LdapGroupHydrator;
use API\LdapGroupModel\Repository\LdapGroupRepository;
use API\LdapGroupModel\Repository\LdapGroupRepositoryInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class GroupRestController extends AbstractRestfulController
{
    /**
     * @var LdapGroupRepositoryInterface | LdapGroupRepository
     */
    private $ldapGroupRepository;

    /**
     * @var LdapGroupHydrator
     */
    private $ldapGroupHydrator;

    /**
     * @param mixed $ldapGroupRepository
     */
    public function setLdapGroupRepository($ldapGroupRepository)
    {
        $this->ldapGroupRepository = $ldapGroupRepository;
    }

    /**
     * @param mixed $ldapGroupHydrator
     */
    public function setLdapGroupHydrator($ldapGroupHydrator)
    {
        $this->ldapGroupHydrator = $ldapGroupHydrator;
    }

    public function getList()
    {
        $q = $this->params()->fromQuery('q');
        if ($q) {
            return $this->get($q);
        }

        return new JsonModel(['error' => 'Param q not defined']);
    }

    public function get($id)
    {
        $filter  = $this->params()->fromQuery('filter', 'dn');
        $count   = $this->params()->fromQuery('count', 30);
		$extract = $this->params()->fromQuery('extract', null);

        if ($filter == 'dn') {
            $entity = $this->ldapGroupRepository->getUserByDn($id);
            if (!$entity) {
                return new JsonModel(['error' => 'Group not found in LDAP']);
            }

            return new JsonModel($this->ldapGroupHydrator->extract($entity));
        } else {
            $result = $this->ldapGroupRepository->searchUser($id, $filter);
            $entity = [];

            if (count($result) > 0) {
                $counter = 0;
                /** @var LdapGroupEntity $item */
                foreach ($result as $item) {
                    if ($extract == null) {
						$entity[] = $this->ldapGroupHydrator->extract($item);

						$counter = $counter + 1;
						if ($counter == $count) {
							break;
						}
					} else {
						$entity[] = $item->$extract()[0];

						$counter = $counter + 1;
						if ($counter == $count) {
							break;
						}
					}
                }

                return new JsonModel($entity);
            } else {
                return new JsonModel(['error' => 'Group not found in LDAP']);
            }


        }
    }
}