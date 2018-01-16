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
 * Class VisibilityItem
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="visibility_item",
 *    uniqueConstraints={
 *        @UniqueConstraint(
 *          name="visibility_item_unique",
 *          columns={"user_id", "item_id"}
 *        )
 *    })
 */
class VisibilityItem
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="visibilityItems")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;
    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="visibilityItems")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
    protected $item;
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
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
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