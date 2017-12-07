<?php
/**
 * Created by PhpStorm.
 * User: jdebos
 * Date: 07/12/2017
 * Time: 13:49
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Craft
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="craft")
 */
class Craft
{
    /**
     * @var Object
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Object", inversedBy="craftSourceOne")
     */
    private $objectSourceOne;
    /**
     * @var Object
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Object", inversedBy="craftSourceTwo")
     */
    private $objectSourceTwo;
    /**
     * @var Object
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Object", inversedBy="craftResult")
     */
    private $objectResult;

    /**
     * Inventory constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return Object
     */
    public function getObjectSourceOne(): Object
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
    public function getObjectSourceTwo(): Object
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
    public function getObjectResult(): Object
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