<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 13:56
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Object
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="object")
 * @Vich\Uploadable
 */
class Object
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $image;

    /**
     * @var File
     * @Vich\UploadableField(mapping="object_images", fileNameProperty="image")
     */
    protected $imageFile;
    /**
     * @var boolean
     * @ORM\Column(name="isvalid", type="boolean", length=255, nullable=true, options={"default":false})
     */
    private $isValid;
    /**
     * @var ArrayCollection<Inventory>
     * @ORM\OneToMany(targetEntity="App\Entity\Inventory", mappedBy="object")
     */
    protected $inventories;
    /**
     * @var ArrayCollection<VisibilityObject>
     * @ORM\OneToMany(targetEntity="App\Entity\VisibilityObject", mappedBy="object")
     */
    protected $visibilityObjects;
    /**
     * @var ArrayCollection<TypeObject>
     * @ORM\ManyToMany(targetEntity="App\Entity\TypeObject", inversedBy="objects", cascade={"persist"})
     * @ORM\JoinTable(
     *      name="objects_type",
     *      joinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="type_object_id", referencedColumnName="id")}
     * )
     */
    private $typeObjects;
    /**
     * @var ArrayCollection<Craft>
     * @ORM\OneToMany(targetEntity="App\Entity\Craft", mappedBy="objectSourceOne")
     */
    protected $craftsSourceOne;
    /**
     * @var ArrayCollection<Craft>
     * @ORM\OneToMany(targetEntity="App\Entity\Craft", mappedBy="objectSourceTwo")
     */
    protected $craftsSourceTwo;
    /**
     * @var ArrayCollection<Craft>
     * @ORM\OneToMany(targetEntity="App\Entity\Craft", mappedBy="objectResult")
     */
    protected $craftsResult;

    /**
     * Object constructor.
     */
    public function __construct()
    {
        $this->inventories = new ArrayCollection();
        $this->visibilityObjects = new ArrayCollection();
        $this->typeObjects = new ArrayCollection();
        $this->craftsSourceOne = new ArrayCollection();
        $this->craftsSourceTwo = new ArrayCollection();
        $this->craftsResult = new ArrayCollection();
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
     * @return string
     */
    public function getName()
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
//        if ($imageFile) {
//            $this->updatedAt = new \DateTime('now');
//        }
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
     * Add typeObject
     *
     * @param TypeObject $typeObject
     *
     * @return $this
     */
    public function addTypeObject(TypeObject $typeObject)
    {
        $this->typeObjects->add($typeObject);

        return $this;
    }

    /**
     * Remove typeObject
     *
     * @param TypeObject $typeObject
     */
    public function removeTypeObject(TypeObject $typeObject)
    {
        $this->typeObjects->removeElement($typeObject);
    }

    /**
     * @return ArrayCollection
     */
    public function getTypeObjects()
    {
        return $this->typeObjects;
    }

    /**
     * @param ArrayCollection $typeObjects
     */
    public function setTypeObjects(ArrayCollection $typeObjects)
    {
        $this->typeObjects = $typeObjects;
    }

    /**
     * Add visibilityObject
     *
     * @param VisibilityObject $visibilityObject
     *
     * @return $this
     */
    public function addVisibilityObject(VisibilityObject $visibilityObject)
    {
        $this->visibilityObjects->add($visibilityObject);

        return $this;
    }

    /**
     * Remove visibilityObject
     *
     * @param VisibilityObject $visibilityObject
     */
    public function removeVisibilityObject(VisibilityObject $visibilityObject)
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

    /**
     * Add craftSourceOne
     *
     * @param Craft $craftSourceOne
     *
     * @return $this
     */
    public function addCraftSourceOne(Craft $craftSourceOne)
    {
        $this->craftsSourceOne->add($craftSourceOne);

        return $this;
    }

    /**
     * Remove craftSourceOne
     *
     * @param Craft $craftSourceOne
     */
    public function removeCraftSourceOne(Craft $craftSourceOne)
    {
        $this->craftsSourceOne->removeElement($craftSourceOne);
    }

    /**
     * @return ArrayCollection
     */
    public function getCraftsSourceOne()
    {
        return $this->craftsSourceOne;
    }

    /**
     * @param ArrayCollection $craftsSourceOne
     */
    public function setCraftsSourceOne(ArrayCollection $craftsSourceOne)
    {
        $this->craftsSourceOne = $craftsSourceOne;
    }

    /**
     * Add craftSourceTwo
     *
     * @param Craft $craftSourceTwo
     *
     * @return $this
     */
    public function addCraftSourceTwo(Craft $craftSourceTwo)
    {
        $this->craftsSourceTwo->add($craftSourceTwo);

        return $this;
    }

    /**
     * Remove craftSourceTwo
     *
     * @param Craft $craftSourceTwo
     */
    public function removeCraftSourceTwo(Craft $craftSourceTwo)
    {
        $this->craftsSourceTwo->removeElement($craftSourceTwo);
    }

    /**
     * @return ArrayCollection
     */
    public function getCraftsSourceTwo()
    {
        return $this->craftsSourceTwo;
    }

    /**
     * @param ArrayCollection $craftsSourceTwo
     */
    public function setCraftsSourceTwo(ArrayCollection $craftsSourceTwo)
    {
        $this->craftsSourceTwo = $craftsSourceTwo;
    }

    /**
     * Add craftResult
     *
     * @param Craft $craftResult
     *
     * @return $this
     */
    public function addCraftResult(Craft $craftResult)
    {
        $this->craftsResult->add($craftResult);

        return $this;
    }

    /**
     * Remove craftResult
     *
     * @param Craft $craftResult
     */
    public function removeCraftResult(Craft $craftResult)
    {
        $this->craftsResult->removeElement($craftResult);
    }

    /**
     * @return ArrayCollection
     */
    public function getCraftsResult()
    {
        return $this->craftsResult;
    }

    /**
     * @param ArrayCollection $craftsResult
     */
    public function setCraftsResult(ArrayCollection $craftsResult)
    {
        $this->craftsResult = $craftsResult;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->name;
    }
}