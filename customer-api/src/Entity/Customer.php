<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="customers")
 * @ORM\Entity
 */
class Customer implements UserInterface
{
    /**
     * @ORM\Column(name="id" ,type="integer", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="username",type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(name="password",type="string", length=500)
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct($username)
    {
        $this->isActive = true;
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }
}