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
    private $user;

    /**
     * @var \MeritocrateBundle\Entity\Rator
     */
    private $rator;

    /**
     * @var \MeritocrateBundle\Entity\Discussion
     */
    private $discussion;

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
     * Set user
     *
     * @param \MeritocrateBundle\Entity\User $user
     *
     * @return Merits
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
     * Set rator
     *
     * @param \MeritocrateBundle\Entity\Rator $rator
     *
     * @return Merits
     */
    public function setRator(\MeritocrateBundle\Entity\Rator $rator = null)
    {
        $this->rator = $rator;

        return $this;
    }

    /**
     * Get rator
     *
     * @return \MeritocrateBundle\Entity\Rator
     */
    public function getRator()
    {
        return $this->rator;
    }

    /**
     * Set discussion
     *
     * @param \MeritocrateBundle\Entity\Discussion $discussion
     *
     * @return Merits
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
