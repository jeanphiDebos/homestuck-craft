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
 *          columns={"object_source_one_id", "object_source_two_id", "object_result_id"}
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
     * @var Object
     * @ORM\ManyToOne(targetEntity="App\Entity\Object", inversedBy="craftsSourceOne")
     * @ORM\JoinColumn(name="object_source_one_id", referencedColumnName="id", nullable=false)
     */
    protected $objectSourceOne;
    /**
     * @var Object
     * @ORM\ManyToOne(targetEntity="App\Entity\Object", inversedBy="craftsSourceTwo")
     * @ORM\JoinColumn(name="object_source_two_id", referencedColumnName="id", nullable=false)
     */
    protected $objectSourceTwo;
    /**
     * @var Object
     * @ORM\ManyToOne(targetEntity="App\Entity\Object", inversedBy="craftsResult")
     * @ORM\JoinColumn(name="object_result_id", referencedColumnName="id", nullable=false)
     */
    protected $objectResult;

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
     * @return Object
     */
    public function getObjectSourceOne()
    {
        return $this->objectSourceOne;
    }

    /**
     * @param Object $objectSourceOne
     */
    public function setObjectSourceOne(Object $objectSourceOne)
    {
        $this->objectSourceOne = $objectSourceOne;
    }

    /**
     * @return Object
     */
    public function getObjectSourceTwo()
    {
        return $this->objectSourceTwo;
    }

    /**
     * @param Object $objectSourceTwo
     */
    public function setObjectSourceTwo(Object $objectSourceTwo)
    {
        $this->objectSourceTwo = $objectSourceTwo;
    }

    /**
     * @return Object
     */
    public function getObjectResult()
    {
        return $this->objectResult;
    }

    /**
     * @param Object $objectResult
     */
    public function setObjectResult(Object $objectResult)
    {
        $this->objectResult = $objectResult;
    }
}