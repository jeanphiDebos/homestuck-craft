<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 14:44
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Capacity
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="capacity_hs")
 */
class Capacity
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="lvl", type="integer", nullable=false)
     */
    protected $lvl;
    /**
     * @var integer
     * @ORM\Column(name="capacity", type="integer", nullable=false, options={"default" : 0})
     */
    protected $capacity;
    /**
     * @var integer
     * @ORM\Column(name="max_type_object_craft", type="integer", nullable=false, options={"default" : 0})
     */
    protected $maxTypeObjectCraft;

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
    public function getMaxTypeObjectCraft()
    {
        return $this->maxTypeObjectCraft;
    }

    /**
     * @param int $maxTypeObjectCraft
     */
    public function setMaxTypeObjectCraft(int $maxTypeObjectCraft)
    {
        $this->maxTypeObjectCraft = $maxTypeObjectCraft;
    }

}