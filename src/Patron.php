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

		function setName($new_name)
		{
			$this->name = $new_name;
		}

		function getId()
		{
			return $this->id;
		}

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons");
            $patrons = array();
            foreach($returned_patrons as $patron){
                 $name = $patron['name'];
                 $id = $patron['id'];
                 $new_patron = new Patron($name, $id);
                 array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons");
        }

        // FIND A SPECIFIC PATRON BY ID
        static function find($id)
        {
            $all_patrons = Patron::getAll();
            $found_patron = null;
            foreach($all_patrons as $patron) {
                $patron_id = $patron->getId();
                if ($patron_id == $id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }
	}
 ?>
