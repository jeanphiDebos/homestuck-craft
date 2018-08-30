<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 13:49
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class VisibilityItem
 * @package App\Entity
 * @ApiResource
 * @ORM\Entity
 * @ORM\Table(name="visibility_craft_item",
 *    uniqueConstraints={
 *        @UniqueConstraint(
 *          name="visibility_craft_item_unique",
 *          columns={"user_id", "craft_id"}
 *        )
 *    })
 */
class VisibilityCraftItem
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"readCraft"})
     */
    protected $id;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="visibilityCraftItems")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Groups({"readCraft"})
     */
    protected $user;
    /**
     * @var Craft
     * @ORM\ManyToOne(targetEntity="App\Entity\Craft", inversedBy="visibilityCraftItems")
     * @ORM\JoinColumn(name="craft_id", referencedColumnName="id", nullable=false)
     */
    protected $craft;
    /**
     * @var boolean
     * @ORM\Column(name="isvalid", type="boolean", options={"default":true})
     * @Groups({"readCraft"})
     */
    protected $isValid;

    /**
     * Inventory constructor.
     */
    public function __construct()
    {
        $this->isValid = true;
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
     * @return Craft
     */
    public function getCraft()
    {
        return $this->craft;
    }

    /**
     * @param Craft $craft
     */
    public function setCraft(Craft $craft)
    {
        $this->craft = $craft;
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