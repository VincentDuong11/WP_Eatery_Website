<?php
class Customer
{
    private $customerName;
    private $phoneNumber;
    private $emailAddress;
    private $referrer;

    public function __construct($name, $phone, $email, $ref)
    {
        $this->setName($name);
        $this->setPhone($phone);
        $this->setEmail($email);
        $this->setRef($ref);
    }

    public function setName($name)
    {
        $this->customerName = $name;
    }

    public function setPhone($number)
    {
        $this->phoneNumber = $number;
    }
    
    public function setEmail($email)
    {
        $this->emailAddress = $email;
    }

    public function setRef($ref)
    {
        $this->referrer = $ref;
    }
    public function getName()
    {
        return $this->customerName;
    }
    public function getPhone()
    {
        return $this->phoneNumber;
    }
    public function getEmail()
    {
        return $this->emailAddress;
    }
    public function getRef()
    {
        return $this->referrer;
    }
}
