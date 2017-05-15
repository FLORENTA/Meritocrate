<?php

namespace MeritocrateBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{

    /**
     * @var string
     */
    private $fullname;

    /**
     * @var \DateTime
     */
    private $dateofbirth;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $nationality;

    /**
     * @var string
     */
    private $ethnicity;

    /**
     * @var string
     */
    private $picture;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $merits;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $speeches;


    /**
     * Set fullname
     *
     * @param string $fullname
     *
     * @return User
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set dateofbirth
     *
     * @param \DateTime $dateofbirth
     *
     * @return User
     */
    public function setDateofbirth($dateofbirth)
    {
        $this->dateofbirth = $dateofbirth;

        return $this;
    }

    /**
     * Get dateofbirth
     *
     * @return \DateTime
     */
    public function getDateofbirth()
    {
        return $this->dateofbirth;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     *
     * @return User
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set ethnicity
     *
     * @param string $ethnicity
     *
     * @return User
     */
    public function setEthnicity($ethnicity)
    {
        $this->ethnicity = $ethnicity;

        return $this;
    }

    /**
     * Get ethnicity
     *
     * @return string
     */
    public function getEthnicity()
    {
        return $this->ethnicity;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return User
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Add merit
     *
     * @param \MeritocrateBundle\Entity\Merits $merit
     *
     * @return User
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
     * @return User
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $rators;


    /**
     * Add rator
     *
     * @param \MeritocrateBundle\Entity\Rator $rator
     *
     * @return User
     */
    public function addRator(\MeritocrateBundle\Entity\Rator $rator)
    {
        $this->rators[] = $rator;

        return $this;
    }

    /**
     * Remove rator
     *
     * @param \MeritocrateBundle\Entity\Rator $rator
     */
    public function removeRator(\MeritocrateBundle\Entity\Rator $rator)
    {
        $this->rators->removeElement($rator);
    }

    /**
     * Get rators
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRators()
    {
        return $this->rators;
    }
}
