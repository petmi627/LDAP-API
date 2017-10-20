<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 18/10/2017 13:45
 */

namespace API\ApiFrontend\Controller;


use API\LdapUserModel\Entity\LdapUserEntity;
use API\LdapUserModel\Hydrator\LdapUserHydrator;
use API\LdapUserModel\Repository\LdapUserRepository;
use API\UserModel\Hydrator\UserHydrator;
use API\UserModel\Repository\UserRepository;
use API\UserModel\Repository\UserRepositoryInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class UserRestController extends AbstractRestfulController
{
    /**
     * @var LdapUserRepository
     */
    private $ldapUserRepository;

    /**
     * @var LdapUserHydrator
     */
    private $ldapUserHydrator;

    /**
     * @var UserRepositoryInterface | UserRepository
     */
    private $userRepository;

    /**
     * @var UserHydrator
     */
    private $userHydrator;

    /**
     * @param LdapUserRepository $ldapUserRepository
     */
    public function setLdapUserRepository($ldapUserRepository)
    {
        $this->ldapUserRepository = $ldapUserRepository;
    }

    /**
     * @param LdapUserHydrator $ldapUserHydrator
     */
    public function setLdapUserHydrator(LdapUserHydrator $ldapUserHydrator)
    {
        $this->ldapUserHydrator = $ldapUserHydrator;
    }

    /**
     * @param UserRepository|UserRepositoryInterface $userRepository
     */
    public function setUserRepository(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function setUserHydrator(UserHydrator $hydrator)
    {
        $this->userHydrator = $hydrator;
    }







    public function get($id)
    {
        $format = $this->params()->fromQuery('format', 'json');
        $filter = $this->params()->fromQuery('filter', 'dn');

        if ($filter == 'dn') {
            $entity = $this->ldapUserRepository->getUserByDn($id);
            if (!$entity) {
                return new JsonModel(['error' => 'User not found in LDAP']);
            }
        } else {
            $result = $this->ldapUserRepository->searchUser($id, $filter);

            if (count($result) > 0) {
                /** @var LdapUserEntity $item */
                foreach ($result as $item) {
                    $entity[] = $this->ldapUserHydrator->extract($item);
                }

                return new JsonModel($entity);
            } else if (is_null($result)) {
                return new JsonModel(['error' => 'User not found in LDAP']);
            }
        }


        return new JsonModel($this->ldapUserHydrator->extract($entity));
    }
}