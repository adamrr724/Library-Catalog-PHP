<?php
	class Copy
		{
		private $book_id;
		private $id;

		function __construct($book_id, $id = null)
		{
			$this->book_id = $book_id;
			$this->id = $id;
		}

		function setBookId($new_book_id)
		{
			$this->book_id = $new_book_id;
		}

        function getBookId()
        {
            return $this->book_id;
        }

		function getId()
		{
			return $this->id;
		}

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ('{$this->getBookId()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies");
            $copies = array();
            foreach($returned_copies as $copy){
                 $book_id = $copy['book_id'];
                 $id = $copy['id'];
                 $new_copy = new Copy($book_id, $id);
                 array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies");
        }

        // FIND A SPECIFIC COPY BY ID
        static function find($id)
        {
            $all_copies = Copy::getAll();
            $found_copy = null;
            foreach($all_copies as $copy) {
                $copy_id = $copy->getId();
                if ($copy_id == $id) {
                    $found_copy = $copy;
                }
            }
            return $found_copy;
        }
	}
 ?>
