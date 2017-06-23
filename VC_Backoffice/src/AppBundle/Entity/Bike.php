<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bike
 *
 * @ORM\Table(name="bike")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BikeRepository")
 */
class Bike
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="wheelSize", type="integer")
     */
    private $wheelSize;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bikes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Bike constructor.
     * @param string $name
     * @param int $wheelSize
     * @param $user
     */
    public function __construct($name, $wheelSize, $user)
    {
        $this->name = $name;
        $this->wheelSize = $wheelSize;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getRides()
    {
        return $this->rides;
    }

    /**
     * @param mixed $rides
     */
    public function setRides($rides)
    {
        $this->rides = $rides;
    }

    /**
     * @ORM\OneToMany(targetEntity="Ride", mappedBy="bike")
     */
    private $rides;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Bike
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set wheelSize
     *
     * @param integer $wheelSize
     *
     * @return Bike
     */
    public function setWheelSize($wheelSize)
    {
        $this->wheelSize = $wheelSize;

        return $this;
    }

    /**
     * Get wheelSize
     *
     * @return int
     */
    public function getWheelSize()
    {
        return $this->wheelSize;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'wheelsize' => $this->wheelSize,    
        );
    }




}
