<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * @var string | null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=10)
     */
    private $FirstName;

    /**
     * @var string | null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=10)
     */
    private $LastName;

    /**
     * @var string | null
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/[0-9]{10}/"
     * )
     */
    private $Phone;

    /**
     * @var string | null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $Email;

    /**
     * @var string | null
     * @Assert\NotBlank()
     * @Assert\length(min=10)
     */
    private $Message;

    /**
     * @var Property|null
     */
    private $Property;


    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    /**
     * @param string|null $FirstName
     * @return Contact
     */
    public function setFirstName(?string $FirstName): Contact
    {
        $this->FirstName = $FirstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    /**
     * @param string|null $LastName
     * @return Contact
     */
    public function setLastName(?string $LastName): Contact
    {
        $this->LastName = $LastName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    /**
     * @param string|null $Phone
     * @return Contact
     */
    public function setPhone(?string $Phone): Contact
    {
        $this->Phone = $Phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->Email;
    }

    /**
     * @param string|null $Email
     * @return Contact
     */
    public function setEmail(?string $Email): Contact
    {
        $this->Email = $Email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->Message;
    }

    /**
     * @param string|null $Message
     * @return Contact
     */
    public function setMessage(?string $Message): Contact
    {
        $this->Message = $Message;
        return $this;
    }

    /**
     * @return Property|null
     */
    public function getProperty(): ?Property
    {
        return $this->Property;
    }

    /**
     * @param Property|null $Property
     * @return Contact
     */
    public function setProperty(?Property $Property): Contact
    {
        $this->Property = $Property;
        return $this;
    }
}