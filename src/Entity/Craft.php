<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 13:49
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Class Craft
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="craft",
 *    uniqueConstraints={
 *        @UniqueConstraint(
 *          name="craft_unique",
 *          columns={"item_source_one_id", "item_source_two_id", "item_result_id"}
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
     */
    protected $id;
    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="craftsSourceOne")
     * @ORM\JoinColumn(name="item_source_one_id", referencedColumnName="id", nullable=false)
     */
    protected $itemSourceOne;
    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="craftsSourceTwo")
     * @ORM\JoinColumn(name="item_source_two_id", referencedColumnName="id", nullable=false)
     */
    protected $itemSourceTwo;
    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="craftsResult")
     * @ORM\JoinColumn(name="item_result_id", referencedColumnName="id", nullable=false)
     */
    protected $itemResult;

    /**
     * Inventory constructor.
     */
    public function __construct()
    {

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
}