<?php

namespace MeritocrateBundle\Entity;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Discussion
 */
class Discussion
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $datecreation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $speeches;

    /**
     * @var boolean
     */
    private $privacy;

    /**
     * @var integer
     */
    private $password;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->speeches = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datecreation = new \DateTime();
        $this->ongoing = true;
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
     * Set name
     *
     * @param string $name
     *
     * @return Discussion
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
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Add speech
     *
     * @param \MeritocrateBundle\Entity\Speech $speech
     *
     * @return Discussion
     */
    public function addSpeech(\MeritocrateBundle\Entity\Speech $speech)
    {
        $this->speeches[] = $speech;

        return $this;
    }

    /**
     * Remove speech
     *
     * @param \MeritocrateBundle\Entity\Speech $speech
     */
    public function removeSpeech(\MeritocrateBundle\Entity\Speech $speech)
    {
        $this->speeches->removeElement($speech);
    }

    /**
     * Get speeches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpeeches()
    {
        return $this->speeches;
    }
    /**
     * @var \MeritocrateBundle\Entity\User
     */
    private $user;

    /**
     * Set user
     *
     * @param \MeritocrateBundle\Entity\User $user
     *
     * @return Discussion
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
     * @var boolean
     */
    private $ongoing;

    /**
     * Get ongoing
     *
     * @return boolean
     */
    public function getOngoing()
    {
        return $this->ongoing;
    }

    /**
     * Set ongoing
     *
     * @var boolean
     */
    public function setOngoing($ongoing)
    {
        $this->ongoing = $ongoing;

        return $this;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Discussion
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Set privacy
     *
     * @param boolean $privacy
     *
     * @return Discussion
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;

        return $this;
    }

    /**
     * Get privacy
     *
     * @return boolean
     */
    public function getPrivacy()
    {
        return $this->privacy;
    }
    

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Discussion
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
