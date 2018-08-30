<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 13:56
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * Class Item
 * @package App\Entity
 * @ApiResource
 * @ApiFilter(BooleanFilter::class, properties={"isVisible", "isValid"})
 * @ORM\Entity
 * @ORM\Table(name="item")
 * @Vich\Uploadable
 */
class Item
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"readInventory", "writeInventory", "readCraft", "writeCraft"})
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups({"readInventory", "readCraft"})
     */
    protected $name;
    /**
     * @var string
     * @ORM\Column(type="text")
     * @Groups({"readInventory", "readCraft"})
     */
    protected $description;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @Groups({"readInventory", "readCraft"})
     */
    protected $cost;
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Groups({"readInventory", "readCraft"})
     */
    protected $image;
    /**
     * @var File
     * @Vich\UploadableField(mapping="item_images", fileNameProperty="image")
     */
    protected $imageFile;
    /**
     * @var boolean
     * @ORM\Column(name="isvisible", type="boolean", options={"default":false})
     * @Groups({"readInventory", "readCraft"})
     */
    private $isVisible;
    /**
     * @var boolean
     * @ORM\Column(name="isvalid", type="boolean", options={"default":false})
     * @Groups({"readInventory", "readCraft"})
     */
    private $isValid;
    /**
     * @var ArrayCollection<Inventory>
     * @ORM\OneToMany(targetEntity="App\Entity\Inventory", mappedBy="item")
     */
    protected $inventories;
    /**
     * @var ArrayCollection<TypeItem>
     * @ORM\ManyToMany(targetEntity="App\Entity\TypeItem", inversedBy="items", cascade={"persist"})
     * @ORM\JoinTable(
     *      name="items_type",
     *      joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="type_item_id", referencedColumnName="id")}
     * )
     * @Groups({"readInventory", "readCraft"})
     */
    private $typeItems;
    /**
     * @var ArrayCollection<Craft>
     * @ORM\OneToMany(targetEntity="App\Entity\Craft", mappedBy="itemSourceOne")
     */
    protected $craftsSourceOne;
    /**
     * @var ArrayCollection<Craft>
     * @ORM\OneToMany(targetEntity="App\Entity\Craft", mappedBy="itemSourceTwo")
     */
    protected $craftsSourceTwo;
    /**
     * @var ArrayCollection<Craft>
     * @ORM\OneToMany(targetEntity="App\Entity\Craft", mappedBy="itemResult")
     */
    protected $craftsResult;

    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->inventories = new ArrayCollection();
        $this->typeItems = new ArrayCollection();
        $this->craftsSourceOne = new ArrayCollection();
        $this->craftsSourceTwo = new ArrayCollection();
        $this->craftsResult = new ArrayCollection();
        $this->isVisible = false;
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
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     */
    public function setCost(string $cost)
    {
        $this->cost = $cost;
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
    public function isVisible()
    {
        return $this->isVisible;
    }

    /**
     * @param bool $isVisible
     */
    public function setIsVisible(bool $isVisible)
    {
        $this->isVisible = $isVisible;
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
     * Add typeItem
     *
     * @param TypeItem $typeItem
     *
     * @return $this
     */
    public function addTypeItem(TypeItem $typeItem)
    {
        $this->typeItems->add($typeItem);

        return $this;
    }

    /**
     * Remove typeItem
     *
     * @param TypeItem $typeItem
     */
    public function removeTypeItem(TypeItem $typeItem)
    {
        $this->typeItems->removeElement($typeItem);
    }

    /**
     * @return ArrayCollection
     */
    public function getTypeItems()
    {
        return $this->typeItems;
    }

    /**
     * @param ArrayCollection $typeItems
     */
    public function setTypeItems(ArrayCollection $typeItems)
    {
        $this->typeItems = $typeItems;
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