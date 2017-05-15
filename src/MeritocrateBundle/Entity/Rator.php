<?php

namespace MeritocrateBundle\Entity;

/**
 * Rator
 */
class Rator
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $merits;

    /**
     * @var \MeritocrateBundle\Entity\User
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->merits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add merit
     *
     * @param \MeritocrateBundle\Entity\Merits $merit
     *
     * @return Rator
     */
    public function addMerit(\MeritocrateBundle\Entity\Merits $merit)
    {
        $this->merits[] = $merit;

        return $this;
    }

    /**
     * Remove merit
     *
     * @param \MeritocrateBundle\Entity\Merits $merit
     */
    public function removeMerit(\MeritocrateBundle\Entity\Merits $merit)
    {
        $this->merits->removeElement($merit);
    }

    /**
     * Get merits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMerits()
    {
        return $this->merits;
    }

    /**
     * Set user
     *
     * @param \MeritocrateBundle\Entity\User $user
     *
     * @return Rator
     */
    public function setUser(\MeritocrateBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MeritocrateBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
