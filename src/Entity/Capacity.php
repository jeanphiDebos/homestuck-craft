<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 14:44
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Capacity
 * @package App\Entity
 * @ApiResource
 * @ApiFilter(SearchFilter::class, properties={"lvl": "exact"})
 * @ApiResource
 * @ORM\Entity()
 * @ORM\Table(name="capacity_hs")
 */
class Capacity
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $lvl;
    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false, options={"default" : 0})
     */
    protected $capacity;
    /**
     * @var integer
     * @ORM\Column(name="max_type_item_craft", type="integer", nullable=false, options={"default" : 0})
     */
    protected $maxTypeItemCraft;

    /**
     * Capacity constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getLvl()
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
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param int $capacity
     */
    public function setCapacity(int $capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return int
     */
    public function getMaxTypeItemCraft()
    {
        return $this->maxTypeItemCraft;
    }

    /**
     * @param int $maxTypeItemCraft
     */
    public function setMaxTypeItemCraft(int $maxTypeItemCraft)
    {
        $this->maxTypeItemCraft = $maxTypeItemCraft;
    }
}