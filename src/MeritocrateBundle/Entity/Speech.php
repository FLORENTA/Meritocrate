<?php

namespace MeritocrateBundle\Entity;

/**
 * Speech
 */
class Speech
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $merits;

    /**
     * @var \MeritocrateBundle\Entity\User
     */
    private $user;

    /**
     * @var \MeritocrateBundle\Entity\Discussion
     */
    private $discussion;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->merits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime();
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
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Add merit
     *
     * @param \MeritocrateBundle\Entity\Merits $merit
     *
     * @return Speech
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
     * @return Speech
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

    /**
     * Set discussion
     *
     * @param \MeritocrateBundle\Entity\Discussion $discussion
     *
     * @return Speech
     */
    public function setDiscussion(\MeritocrateBundle\Entity\Discussion $discussion = null)
    {
        $this->discussion = $discussion;

        return $this;
    }

    /**
     * Get discussion
     *
     * @return \MeritocrateBundle\Entity\Discussion
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }
}
