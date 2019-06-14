<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class User
 * @package App\Entity
 * @ApiResource
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"readInventory", "writeInventory", "readCraft"})
     */
    protected $id;
    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false, options={"default" : 1})
     * @Groups({"readInventory", "readCraft"})
     */
    protected $lvl;
    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false, options={"default" : 1})
     * @Groups({"readInventory", "readCraft"})
     */
    protected $resource;
    /**
     * @var ArrayCollection<Inventory>
     * @ORM\OneToMany(targetEntity="App\Entity\Inventory", mappedBy="user")
     */
    protected $inventories;
    /**
     * @var ArrayCollection<VisibilityCraftItem>
     * @ORM\OneToMany(targetEntity="App\Entity\VisibilityCraftItem", mappedBy="user")
     */
    protected $visibilityCraftItems;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->inventories = new ArrayCollection();
        $this->visibilityCraftItems = new ArrayCollection();
        $this->lvl = 1;
        $this->resource = 1;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * @param integer $lvl
     */
    public function setLvl(string $lvl)
    {
        $this->lvl = $lvl;
    }

    /**
     * @return integer
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param integer $resource
     */
    public function setResource(string $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
//        return in_array(static::ROLE_SUPER_ADMIN, $this->roles);
        return false;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
//        if ($isAdmin) {
//            if (!$this->isAdmin()) {
//                $this->roles[] = static::ROLE_SUPER_ADMIN;
//            }
//        } else {
//            $roles = array_flip($this->roles);
//            unset($roles[static::ROLE_SUPER_ADMIN]);
//            $this->roles = array_flip($roles);
//        }
    }

    /**
     * Add inventory
     *
     * @param Inventory $inventory
     *
     * @return $this
     */
    public function addInventory(Inventory $inventory)
    {
        $this->inventories->add($inventory);

        return $this;
    }

    /**
     * Remove inventory
     *
     * @param Inventory $inventory
     */
    public function removeInventory(Inventory $inventory)
    {
        $this->inventories->removeElement($inventory);
    }

    /**
     * @return ArrayCollection
     */
    public function getInventories()
    {
        return $this->inventories;
    }

    /**
     * @param ArrayCollection $inventories
     */
    public function setInventories($inventories)
    {
        $this->inventories = $inventories;
    }

    /**
     * Add visibilityCraftItems
     *
     * @param VisibilityCraftItem $visibilityCraftItem
     *
     * @return $this
     */
    public function addVisibilityCraftItem(VisibilityCraftItem $visibilityCraftItem)
    {
        $this->visibilityCraftItems->add($visibilityCraftItem);

        return $this;
    }

    /**
     * Remove visibilityCraftItems
     *
     * @param VisibilityCraftItem $visibilityCraftItem
     */
    public function removeVisibilityCraftItem(VisibilityCraftItem $visibilityCraftItem)
    {
        $this->visibilityCraftItems->removeElement($visibilityCraftItem);
    }

    /**
     * @return ArrayCollection
     */
    public function getVisibilityCraftItems()
    {
        return $this->visibilityCraftItems;
    }

    /**
     * @param ArrayCollection $visibilityCraftItems
     */
    public function setVisibilityCraftItems($visibilityCraftItems)
    {
        $this->visibilityCraftItems = $visibilityCraftItems;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->username;
    }
}