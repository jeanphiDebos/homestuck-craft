<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
//class User extends BaseUser
class User
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(name="lvl", type="integer", nullable=false, options={"default" : 1})
     */
    private $lvl;
    /**
     * @var ArrayCollection<Inventory>
     * @ORM\OneToMany(targetEntity="App\Entity\Inventory", mappedBy="user")
     */
    protected $inventories;
    /**
     * @var ArrayCollection<VisibilityObject>
     * @ORM\OneToMany(targetEntity="App\Entity\VisibilityObject", mappedBy="user")
     */
    protected $visibilityObjects;

    /**
     * User constructor.
     */
    public function __construct()
    {
//        parent::__construct();
        $this->inventories = new ArrayCollection();
        $this->visibilityObjects = new ArrayCollection();
        $this->lvl = 1;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLvl(): string
    {
        return $this->lvl;
    }

    /**
     * @param string $lvl
     */
    public function setLvl(string $lvl)
    {
        $this->lvl = $lvl;
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
     * Add visibilityObject
     *
     * @param visibilityObject $visibilityObject
     *
     * @return $this
     */
    public function addVisibilityObject(visibilityObject $visibilityObject)
    {
        $this->visibilityObjects->add($visibilityObject);

        return $this;
    }

    /**
     * Remove visibilityObject
     *
     * @param visibilityObject $visibilityObject
     */
    public function removeVisibilityObject(visibilityObject $visibilityObject)
    {
        $this->visibilityObjects->removeElement($visibilityObject);
    }

    /**
     * @return ArrayCollection
     */
    public function getVisibilityObjects()
    {
        return $this->visibilityObjects;
    }

    /**
     * @param ArrayCollection $visibilityObjects
     */
    public function setVisibilityObjects($visibilityObjects)
    {
        $this->visibilityObjects = $visibilityObjects;
    }
}