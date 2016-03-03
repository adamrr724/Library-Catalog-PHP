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

        function update($new_name)
        {
           $GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_name}' WHERE id={$this->getId()};");
           $this->setName($new_name);
        }

        static function search($search_term)
		{
			$query = $GLOBALS['DB']->query("SELECT * FROM patrons WHERE name LIKE '%{$search_term}%'");
			$all_patrons = $query->fetchAll(PDO::FETCH_ASSOC);

			$found_patrons = array();
			foreach ($all_patrons as $patron) {
				$name = $patron['name'];
				$id = $patron['id'];
				$new_patron = new Patron($name, $id);
				array_push($found_patrons, $new_patron);
			}
			return $found_patrons;
		}

		function delete()
		{
			 $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
		}

		function getPatronBooks()
		{
			$query = $GLOBALS['DB']->query("SELECT checkouts.* FROM
          patrons JOIN checkouts ON (patrons.id = checkouts.patron_id)
          WHERE patrons.id = {$this->getId()}");
			$all_checkouts = $query->fetchAll(PDO::FETCH_ASSOC);

			$books = array();
			foreach ($all_checkouts as $checkout) {
				$book_id = $checkout['book_id'];
				array_push($books, $book_id);
			}
			 return $books;
		}
	}
 ?>
