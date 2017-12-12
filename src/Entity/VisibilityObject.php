<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 13:49
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Class VisibilityObject
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="visibility_object",
 *    uniqueConstraints={
 *        @UniqueConstraint(
 *          name="visibility_object_unique",
 *          columns={"user_id", "object_id"}
 *        )
 *    })
 */
class VisibilityObject
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="visibilityObjects")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;
    /**
     * @var Object
     * @ORM\ManyToOne(targetEntity="App\Entity\Object", inversedBy="visibilityObjects")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", nullable=false)
     */
    protected $object;
    /**
     * @var boolean
     * @ORM\Column(name="isvalid", type="boolean", length=255, nullable=true, options={"default":false})
     */
    protected $isValid;

    /**
     * Inventory constructor.
     */
    public function __construct()
    {
        $this->isValid = false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
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
    public function getObject()
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
    public function isValid()
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