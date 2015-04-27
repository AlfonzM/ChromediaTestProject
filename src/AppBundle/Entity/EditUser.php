<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class EditUser{
	protected $email;
	protected $firstname;
	protected $lastname;

	public function getFirstName(){
		return $this->firstname;
	}

	public function setFirstName($name){
		$this->firstname = $name;
	}

	public function getLastName(){
		return $this->lastname;
	}

	public function setLastName($name){
		$this->lastname = $name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}
}
