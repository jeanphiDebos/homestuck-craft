<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 13:49
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Class Craft
 * @package App\Entity
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"readCraft"}},
 *     "denormalization_context"={"groups"={"writeCraft"}}
 * })
 * @ApiFilter(SearchFilter::class, properties={"itemSourceOne.id": "exact", "itemSourceTwo.id": "exact", "operation": "exact"})
 * @ORM\Entity
 * @ORM\Table(name="craft",
 *    uniqueConstraints={
 *        @UniqueConstraint(
 *          name="craft_unique",
 *          columns={"item_source_one_id", "item_source_two_id", "operation", "item_result_id"}
 *        )
 *    })
 */
class Craft
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
     * @var Item
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="craftsSourceOne")
     * @ORM\JoinColumn(name="item_source_one_id", referencedColumnName="id", nullable=false)
     * @Groups({"writeCraft"})
     */
    protected $itemSourceOne;
    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="craftsSourceTwo")
     * @ORM\JoinColumn(name="item_source_two_id", referencedColumnName="id", nullable=false)
     * @Groups({"writeCraft"})
     */
    protected $itemSourceTwo;
    /**
     * @var string
     * @ORM\Column(type="string", columnDefinition="enum('OR', 'AND')")
     * @Groups({"readCraft", "writeCraft"})
     */
    protected $operation;
    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="craftsResult")
     * @ORM\JoinColumn(name="item_result_id", referencedColumnName="id", nullable=false)
     * @Groups({"readCraft", "writeCraft"})
     */
    protected $itemResult;
    /**
     * @var ArrayCollection<VisibilityCraftItem>
     * @ORM\OneToMany(targetEntity="App\Entity\VisibilityCraftItem", mappedBy="craft")
     * @Groups({"readCraft"})
     */
    protected $visibilityCraftItems;

    /**
     * Inventory constructor.
     */
    public function __construct()
    {
        $this->visibilityCraftItems = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Item
     */
    public function getItemSourceOne()
    {
        return $this->itemSourceOne;
    }

    /**
     * @param Item $itemSourceOne
     */
    public function setItemSourceOne(Item $itemSourceOne)
    {
        $this->itemSourceOne = $itemSourceOne;
    }

    /**
     * @return Item
     */
    public function getItemSourceTwo()
    {
        return $this->itemSourceTwo;
    }

    /**
     * @param Item $itemSourceTwo
     */
    public function setItemSourceTwo(Item $itemSourceTwo)
    {
        $this->itemSourceTwo = $itemSourceTwo;
    }

    /**
     * @return int
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param int $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     * @return Item
     */
    public function getItemResult()
    {
        return $this->itemResult;
    }

    /**
     * @param Item $itemResult
     */
    public function setItemResult(Item $itemResult)
    {
        $this->itemResult = $itemResult;
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
        return (string)$this->itemResult->getName();
    }
}