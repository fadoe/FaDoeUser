<?php

namespace FadoeUser\Entity;

use ZfcUser\Entity\UserInterface as ZfcUserInterface;

interface UserInterface extends ZfcUserInterface
{

    /**
     * get firstName
     *
     * @return string
     */
    public function getFirstName();

    /**
     * set firstName
     *
     * @param string $firstName
     * @return UserInterface
     */
    public function setFirstName($firstName);

    /**
     * get lastName
     *
     * @return string
     */
    public function getLastName();

    /**
     * set lastName
     *
     * @param string $lastName
     * @return UserInterface
     */
    public function setLastName($lastName);

}
