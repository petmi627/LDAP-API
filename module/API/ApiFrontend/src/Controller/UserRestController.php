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
use API\UserModel\Entity\UserEntity;
use API\UserModel\Hydrator\UserHydrator;
use API\UserModel\InputFilter\UserInputFilter;
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
     * @var UserInputFilter
     */
    private $userInputFilter;

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

    /**
     * @param UserInputFilter $userInputFilter
     */
    public function setUserInputFilter($userInputFilter)
    {
        $this->userInputFilter = $userInputFilter;
    }


    public function get($id)
    {
        $filter     = $this->params()->fromQuery('filter', 'dn');
        $count      = $this->params()->fromQuery('count', 15);
        $only_ldap  = $this->params()->fromQuery('only_ldap', false);

        $baseUrl = $this->getBaseUrl();

        if ($filter == 'dn') {
            $entity = $this->ldapUserRepository->getUserByDn($id);
            if (!$entity) {
                return new JsonModel(['error' => 'User not found in LDAP']);
            }

            if (!$only_ldap) {
                $user   = $this->getUserData($entity->getSAMAccountName());
                $url    = $this->userRepository->getUserUrls($entity->getSAMAccountName(), $baseUrl);


                return new JsonModel(array_merge(
                        $this->ldapUserHydrator->extract($entity),
                        $this->userHydrator->extract($user),
                        $url
                    )
                );
            } else {
                return new JsonModel($this->ldapUserHydrator->extract($entity));
            }

        } else {
            $result = $this->ldapUserRepository->searchUser($id, $filter);

            if (count($result) > 0) {
                $counter = 0;
                /** @var LdapUserEntity $item */
                foreach ($result as $item) {
                    if (!$only_ldap) {
                        $user = $this->getUserData($item->getSAMAccountName());
                        $url  = $this->userRepository->getUserUrls($item->getSAMAccountName()[0], $baseUrl);

                        $data = array_merge(
                            $this->ldapUserHydrator->extract($item),
                            $this->userHydrator->extract($user),
                            $url
                        );
                    } else {
                        $data = $this->ldapUserHydrator->extract($item);
                    }

                    $entity[] = $data;

                    $counter = $counter + 1;
                    if ($counter == $count) {
                        break;
                    }
                }

                return new JsonModel($entity);
            } else {
                return new JsonModel(['error' => 'User not found in LDAP']);
            }
        }
    }

    public function update($id, $data)
    {
        $result = $this->ldapUserRepository->searchUser($id, 'sAMAccountName');
        if (count($result) > 0) {
            /** @var LdapUserEntity $item */
            foreach ($result as $item) {
                $user = $this->getUserData($item->getSAMAccountName());
                break;
            }
        } else {
            return new JsonModel(['error' => 'User not found in LDAP']);
        }

        $this->userInputFilter->setData($this->params()->fromQuery());
        if (!$this->userInputFilter->isValid()) {
            return new JsonModel([
                'error'     => 'Invalid data',
                'messages'  => $this->userInputFilter->getMessages()
            ]);
        }

        /** @var UserEntity $user */
        $language = $this->userInputFilter->getValues()['language'];
        $user->setLanguage($language);

        $result = $this->userRepository->saveUser($user);
        if ($result) {
            return new JsonModel(['success' => 'User was successfully updated']);
        } else {
            return new JsonModel(['error' => 'Error while updating User']);
        }
    }


    private function getUserData($username)
    {
        $username = $username[0];
        $user = $this->userRepository->getUser(['username' => $username]);
        if (!$user) {
            $data = ['username' => $username, 'language' => 'en'];
            $entity = $this->userRepository->createEntityFromData($data);
            $result = $this->userRepository->saveUser($entity);
            if ($result) {
                $user = $this->userRepository->getUser(['username' => $username]);
            }
        }

        return $user;
    }

    private function getBaseUrl()
    {
        $event = $this->getEvent();
        $request = $event->getRequest();
        $router = $event->getRouter();
        $uri = $router->getRequestUri();
        return sprintf('%s://%s%s', $uri->getScheme(), $uri->getHost(), $request->getBaseUrl());
    }
}