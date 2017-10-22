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

    public function get($id)
    {
        $filter = $this->params()->fromQuery('filter', 'dn');
        $count  = $this->params()->fromQuery('count', 30);

        if ($filter == 'dn') {
            $entity = $this->ldapGroupRepository->getUserByDn($id);
            if (!$entity) {
                return new JsonModel(['error' => 'Group not found in LDAP']);
            }

            return new JsonModel($this->ldapGroupHydrator->extract($entity));
        } else {
            $result = $this->ldapGroupRepository->searchUser($id, $filter);

            if (count($result) > 0) {
                $counter = 0;
                /** @var LdapGroupEntity $item */
                foreach ($result as $item) {
                    $entity[] = $this->ldapGroupHydrator->extract($item);

                    $counter = $counter + 1;
                    if ($counter == $count) {
                        break;
                    }
                }

                return new JsonModel($entity);
            } else {
                return new JsonModel(['error' => 'Group not found in LDAP']);
            }


        }
    }


}