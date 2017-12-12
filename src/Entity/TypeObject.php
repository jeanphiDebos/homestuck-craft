<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 14:06
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TypeObject
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="type_object")
 */
class TypeObject extends Taxonomy
{
    /**
     * @var ArrayCollection<Object>
     * @ORM\ManyToMany(targetEntity="App\Entity\Object", mappedBy="typeObjects", cascade={"persist"})
     */
    protected $objects;
    /**
     * @var CategoryObject
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryObject", inversedBy="typeObject")
     */
    protected $categoryObject;

    /**
     * TypeObject constructor.
     */
    public function __construct()
    {
        $this->objects = new ArrayCollection();
    }

    /**
     * Add object
     *
     * @param Object $object
     *
     * @return $this
     */
    public function addObject(Object $object)
    {
        $this->objects->add($object);

        return $this;
    }

    /**
     * Remove object
     *
     * @param Object $object
     */
    public function removeObject(Object $object)
    {
        $this->objects->removeElement($object);
    }

    /**
     * @return ArrayCollection
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * @param ArrayCollection $objects
     */
    public function setObjects(ArrayCollection $objects)
    {
        $this->objects = $objects;
    }

    /**
     * @return CategoryObject
     */
    public function getCategoryObject()
    {
        return $this->categoryObject;
    }

    /**
     * @param CategoryObject $categoryObject
     */
    public function setCategoryObject(CategoryObject $categoryObject)
    {
        $this->categoryObject = $categoryObject;
    }
}