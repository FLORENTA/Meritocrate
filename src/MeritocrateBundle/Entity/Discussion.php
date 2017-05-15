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
    private $merits;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $speeches;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->merits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->speeches = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datecreation = new \DateTime();
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
     * Add merit
     *
     * @param \MeritocrateBundle\Entity\Merits $merit
     *
     * @return Discussion
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
}
