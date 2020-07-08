<?php
declare(strict_types=1);


namespace App\Service\User;


use App\Repository\UserRepository;

/**
 * Class userProvider
 * @package App\Service\User
 */
class UserProvider
{
    /**
     * @var UserRepository
     */
    private $userProvider;

    /**
     * userProvider constructor.
     * @param UserRepository $userProvider
     */
    public function __construct(UserRepository $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @return \App\Entity\User[]
     */
    public function getUser()
    {
        return $this->userProvider->findAll();
    }
}