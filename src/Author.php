<?php
	class Author
		{
		private $first_name;
		private $last_name;
		private $id;

		function __construct($first_name, $last_name, $id = null)
		{
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->id = $id;
		}

		function getFirstName()
		{
			return $this->first_name;
		}

		function setFirstName()
		{
			$this->first_name = $first_name;
		}

        function getLastName()
		{
			return $this->last_name;
		}

		function setLastName()
		{
			$this->last_name = $last_name;
		}

		function getId()
		{
			return $this->id;
		}
	}
 ?>
