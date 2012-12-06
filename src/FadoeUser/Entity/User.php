<?php

namespace FadoeUser\Entity;

use ZfcUser\Entity\User as ZfcUser;

class User extends ZfcUser implements UserInterface
{

    /**
     * the first name
     * @var string
     */
    protected $firstName;

    /**
     * the last name
     * @var string
     */
    protected $lastName;

    /**
     * (non-PHPdoc)
     * @see \FadoeUser\Entity\UserInterface::getFirstName()
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * (non-PHPdoc)
     * @see \FadoeUser\Entity\UserInterface::setFirstName()
     */
    public function setFirstName($firstName)
    {
        $this->firstName = (string) $firstName;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \FadoeUser\Entity\UserInterface::getLastName()
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * (non-PHPdoc)
     * @see \FadoeUser\Entity\UserInterface::setLastName()
     */
    public function setLastName($lastName)
    {
        $this->lastName = (string) $lastName;
        return $this;
    }

}
