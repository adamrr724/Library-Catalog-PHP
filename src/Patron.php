<?php
	class Patron
		{
		private $name;
		private $id;

		function __construct($name, $id = null)
		{
			$this->name = $name;
			$this->id = $id;
		}

		function getName()
		{
			return $this->name;
		}

		function setName()
		{
			$this->name = $name;
		}

		function getId()
		{
			return $this->id;
		}
	}
 ?>
