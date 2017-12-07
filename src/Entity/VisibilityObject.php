<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 13:49
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class VisibilityObject
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="visibility_object")
 */
class VisibilityObject
{
    /**
     * @var User
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="visibilityObjects")
     */
    private $user;
    /**
     * @var Object
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Object", inversedBy="visibilityObjects")
     */
    private $object;
    /**
     * @var boolean
     * @ORM\Column(name="isvalid", type="boolean", length=255, nullable=true, options={"default":false})
     */
    private $isValid;

    /**
     * Inventory constructor.
     */
    public function __construct()
    {
        $this->isValid = false;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Object
     */
    public function getObject(): Object
    {
        return $this->object;
    }

    /**
     * @param Object $object
     */
    public function setObject(Object $object)
    {
        $this->object = $object;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @param bool $isValid
     */
    public function setIsValid(bool $isValid)
    {
        $this->isValid = $isValid;
    }
}