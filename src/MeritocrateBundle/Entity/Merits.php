<?php

namespace MeritocrateBundle\Entity;

/**
 * Merits
 */
class Merits
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $datecreation;

    /**
     * @var \MeritocrateBundle\Entity\User
     */
    private $rator;

    /**
     * @var \MeritocrateBundle\Entity\Speech
     */
    private $speech;


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
     * Constructor
     */
    public function __construct()
    {
        $this->datecreation = new \DateTime();

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set rator
     *
     * @param \MeritocrateBundle\Entity\User $rator
     *
     * @return Merits
     */
    public function setRator(\MeritocrateBundle\Entity\User $rator = null)
    {
        $this->rator = $rator;

        return $this;
    }

    /**
     * Get rator
     *
     * @return \MeritocrateBundle\Entity\User
     */
    public function getRator()
    {
        return $this->rator;
    }

    /**
     * Set speech
     *
     * @param \MeritocrateBundle\Entity\Speech $speech
     *
     * @return Merits
     */
    public function setSpeech(\MeritocrateBundle\Entity\Speech $speech = null)
    {
        $this->speech = $speech;

        return $this;
    }

    /**
     * Get speech
     *
     * @return \MeritocrateBundle\Entity\Speech
     */
    public function getSpeech()
    {
        return $this->speech;
    }
}
