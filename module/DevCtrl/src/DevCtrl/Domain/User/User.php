<?php namespace DevCtrl\Domain\User;

use Ctrl\Domain\PersistableModel;

class User extends PersistableModel
{
    protected $username;

    protected $firstName;

    protected $lastName;

    protected $email;

    protected $itemsCreated;

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setItemsCreated($itemsCreated)
    {
        $this->itemsCreated = $itemsCreated;
        return $this;
    }

    public function getItemsCreated()
    {
        return $this->itemsCreated;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }
}