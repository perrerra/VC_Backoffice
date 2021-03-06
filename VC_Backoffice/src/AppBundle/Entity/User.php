<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * User
 *
 * @ORM\Table(name="`fos_user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Bike", mappedBy="user")
     */
    private $bikes;

    /**
     * @ORM\OneToMany(targetEntity="Ride", mappedBy="user")
     */
    private $rides;

    /**
     * @return mixed
     */
    public function getBikes()
    {
        return $this->bikes;
    }

    /**
     * @param mixed $bikes
     */
    public function setBikes($bikes)
    {
        $this->bikes = $bikes;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRides()
    {
        return $this->rides;
    }


    public function getRidesAsArray()
    {
        $rides_array = array();
        foreach ($this->rides as $ride){
            array_push($rides_array, $ride->toArray());
        }
        return $rides_array;
    }

    /**
     * @param mixed $rides
     */
    public function setRides($rides)
    {
        $this->rides = $rides;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
        );
    }

    public function getBikesToArray(){
        $bike_array = array();
        foreach ($this->bikes as $bike){
            array_push($bike_array, $bike->toArray());
        }
        return $bike_array;
    }
}
