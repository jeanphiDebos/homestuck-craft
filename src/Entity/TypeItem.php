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
 * Class TypeItem
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="type_item")
 */
class TypeItem extends Taxonomy
{
    /**
     * @var ArrayCollection<Item>
     * @ORM\ManyToMany(targetEntity="Item", mappedBy="typeItems", cascade={"persist"})
     */
    protected $items;
    /**
     * @var CategoryItem
     * @ORM\ManyToOne(targetEntity="CategoryItem", inversedBy="typeItem")
     */
    protected $categoryItem;

    /**
     * TypeItem constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * Add item
     *
     * @param Item $item
     *
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->items->add($item);

        return $this;
    }

    /**
     * Remove item
     *
     * @param Item $item
     */
    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param ArrayCollection $items
     */
    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;
    }

    /**
     * @return CategoryItem
     */
    public function getCategoryItem()
    {
        return $this->categoryItem;
    }

    /**
     * @param CategoryItem $categoryItem
     */
    public function setCategoryItem(CategoryItem $categoryItem)
    {
        $this->categoryItem = $categoryItem;
    }
}