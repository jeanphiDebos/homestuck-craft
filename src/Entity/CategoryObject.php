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
 * Class CategoryObject
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="category_object")
 */
class CategoryObject extends Taxonomy
{
    /**
     * @var ArrayCollection<TypeObject>
     * @ORM\OneToMany(targetEntity="App\Entity\TypeObject", mappedBy="categoryObject")
     */
    protected $typeObject;

    /**
     * CategoryObject constructor.
     */
    public function __construct()
    {
        $this->typeObject = new ArrayCollection();
    }

    /**
     * Add typeObject
     *
     * @param TypeObject $typeObject
     *
     * @return $this
     */
    public function addTypeObject(TypeObject $typeObject)
    {
        $this->typeObject->add($typeObject);

        return $this;
    }

    /**
     * Remove typeObject
     *
     * @param TypeObject $typeObject
     */
    public function removeTypeObject(TypeObject $typeObject)
    {
        $this->typeObject->removeElement($typeObject);
    }

    /**
     * @return ArrayCollection
     */
    public function getTypeObject()
    {
        return $this->typeObject;
    }

    /**
     * @param ArrayCollection $typeObject
     */
    public function setTypeObject(ArrayCollection $typeObject)
    {
        $this->typeObject = $typeObject;
    }
}