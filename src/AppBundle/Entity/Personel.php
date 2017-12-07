<?php

/**************************************************************************
 * Material.php, Manager
 *
 * Mickael Gaillard Copyright 2017
 * Description :
 * Author(s)   : Dereck Daniel <dereck.daniel@tactfactory.com>
 * Licence     : All right reserved.
 * Last update : 5 déc. 2017
 *
 **************************************************************************/
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * Personel.
 *
 * @ORM\Table(name="app_personel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonelRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @UniqueEntity("id")
 */
class Personel extends EntityBase
{
	/**
	 * @ORM\Column(type="string", name="lastname", nullable=true)
	 *
	 *
	 * @var string
	 */
	private $lastname;
	
	/**
	 * @ORM\OneToMany(targetEntity="Material", mappedBy="personel", cascade={"persist", "remove"})
	 * @var Collection
	 */
	private $materials;
	
	
	public function __construct()
	{
	    $this->materials = new ArrayCollection();
	}
	
	
	/**
	 * Set the materials
	 *
	 * @param ArrayCollection $materials
	 */
	public function setMaterials(ArrayCollection $materials)
	{
	    $this->materials = $materials;
	    return $this;
	}
	
	/**
	 * get the materials
	 *
	 * @return $materials
	 */
	public function getMaterials()
	{
	    return $this->materials;
	}
	
	
	
		
	/**
	 * @return string
	 */
	public function getLastname(){
	return $this->lastname;
	}
	
	/**
	 * @param string $lastname
	 */
	public function setLastname($lastname){
	$this->lastname = $lastname;
	}
}

