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
 * Class Inventory
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="inventory")
 */
class Inventory
{
    /**
     * @var User
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="inventories")
     */
    private $user;
    /**
     * @var Object
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Object", inversedBy="inventories")
     */
    private $object;
    /**
     * @var integer
     * @ORM\Column(name="count", type="integer", nullable=false, options={"default" : 1})
     */
    private $count;

    /**
     * Inventory constructor.
     */
    public function __construct()
    {

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
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = $count;
    }
}