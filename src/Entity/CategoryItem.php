<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 14:06
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CategoryItem
 * @package App\Entity
 * @ApiResource
 * @ORM\Entity()
 * @ORM\Table(name="category_item")
 */
class CategoryItem extends Taxonomy
{
    /**
     * @var ArrayCollection<TypeItem>
     * @ORM\OneToMany(targetEntity="App\Entity\TypeItem", mappedBy="categoryItem")
     */
    protected $typeItem;

    /**
     * CategoryItem constructor.
     */
    public function __construct()
    {
        $this->typeItem = new ArrayCollection();
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
        $this->typeItem->add($typeItem);

        return $this;
    }

    /**
     * Remove typeItem
     *
     * @param TypeItem $typeItem
     */
    public function removeTypeItem(TypeItem $typeItem)
    {
        $this->typeItem->removeElement($typeItem);
    }

    /**
     * @return ArrayCollection
     */
    public function getTypeItem()
    {
        return $this->typeItem;
    }

    /**
     * @param ArrayCollection $typeItem
     */
    public function setTypeItem(ArrayCollection $typeItem)
    {
        $this->typeItem = $typeItem;
    }
}