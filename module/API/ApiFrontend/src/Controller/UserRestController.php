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

    /**
     * @param UserHydrator $hydrator
     */
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

    public function getList()
    {
        $q = $this->params()->fromQuery('q');
        if ($q) {
            return $this->get($q);
        } else {
            return new JsonModel(['error' => 'q param not set']);
        }
    }

    /**
     * Get Method to get Data
     *
     * @param mixed $id
     * @return JsonModel
     */
    public function get($id)
    {
        $headers = $this->getResponse()->getHeaders();
        $headers->addHeaderLine('Access-Control-Allow-Origin: *');
        $headers->addHeaderLine('Access-Control-Allow-Methods: PUT, GET, POST, PATCH, DELETE, OPTIONS');

        //Define Variable;
        $filter     = $this->params()->fromQuery('filter', 'dn');
        $count      = $this->params()->fromQuery('count', 15);
        $only_ldap  = $this->params()->fromQuery('only_ldap', false);

        //Check if Filter need to be applied
        if (in_array($filter, ['dn', 'username'])) {
            //Get Entity
            if ($filter == 'username') {
                $entity = $this->ldapUserRepository->getUserByUsername($id);
            } else {
                $entity = $this->ldapUserRepository->getUserByDn($id);
            }

            if (!$entity) {
                return new JsonModel(['error' => 'User not found in LDAP']);
            }

            //Check if only ldap data need to be returned (is sometime faster)
            if (!$only_ldap) {
                //Merge all arrays and return them as Json
                return new JsonModel(array_merge(
                        ['id' => $entity->getSAMAccountName()],
                        ['text' => $entity->getCn()],
                        $this->ldapUserHydrator->extract($entity),
                        $this->getUrlAndUserData($entity)
                    )
                );
            } else {
                //Only return Ldap Data as Json
                return new JsonModel(array_merge(
                    ['id' => $entity->getSAMAccountName()],
                    ['text' => $entity->getCn()],
                    $this->ldapUserHydrator->extract($entity),
                    $this->getUrlAndUserData($entity, false)
                ));
            }
        } else {
            //Search for a User
            $result = $this->ldapUserRepository->searchUser($id, $filter);

            //Check if we have any LDAP results
            if (count($result) > 0) {
                //Counter if the counter reach the number of @var count the loop will break
                $counter = 0;
                /** @var LdapUserEntity $item */
                foreach ($result as $item) {
                    if (!$only_ldap) {
                        $data = array_merge(
                            ['id' => $item->getSAMAccountName()],
                            ['text' => $item->getCn()],
                            $this->ldapUserHydrator->extract($item),
                            $this->getUrlAndUserData($item)
                        );
                    } else {
                        $data = $this->ldapUserHydrator->extract($item);
                    }

                    //Add data to an Array
                    $entity[] = $data;

                    //Break if Counter reach count
                    $counter = $counter + 1;
                    if ($counter == $count) {
                        break;
                    }
                }

                //Return Data
                return new JsonModel($entity);
            } else {
                //Return Error
                return new JsonModel(['error' => 'User not found in LDAP']);
            }
        }
    }

    /**
     * Put method to update language
     *
     * @param mixed $id
     * @param mixed $data
     * @return JsonModel
     */
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

        $this->userInputFilter->setData($data);
        if (!$this->userInputFilter->isValid()) {
            return new JsonModel([
                'error'     => 'Invalid data',
                'messages'  => $this->userInputFilter->getMessages()
            ]);
        }

        /** @var UserEntity $user */
        $language = $this->userInputFilter->getValues()['language'];
        $cc = $this->userInputFilter->getValues()['clockCardNumber'];

        if ($cc) {
            $user->setClockCardNumber($cc);
        }

        if ($user->getLanguage() != $language || $user->getClockCardNumber()) {
			$user->setLanguage($language);
				
			$result = $this->userRepository->saveUser($user);
				
			if ($result) {
				return new JsonModel(['success' => 'User was successfully updated']);
			} else {
				return new JsonModel(['error' => 'Error while updating User']);				
			}
		} else {
			return new JsonModel(['info' => 'User language was not changed, Database and Input have the same value']);
		}
    }


    /**
     * @param $entity
     * @return array
     */
    private function getUrlAndUserData($entity, $url = true)
    {
        $baseUrl = $this->getBaseUrl();

        $data['user'] = $this->userHydrator->extract($this->getUserData($entity->getSAMAccountName()));
        if ($url) {
            $data['url']  = $this->userRepository->getUserUrls($entity->getSAMAccountName()[0], $baseUrl);
        }

        return $data;
    }

    /**
     * @param string $username
     * @return UserEntity
     */
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

    /**
     * @return string
     */
    private function getBaseUrl()
    {
        $event = $this->getEvent();
        $request = $event->getRequest();
        $router = $event->getRouter();
        $uri = $router->getRequestUri();
        return sprintf('%s://%s%s', $uri->getScheme(), $uri->getHost(), $request->getBaseUrl());
    }
}