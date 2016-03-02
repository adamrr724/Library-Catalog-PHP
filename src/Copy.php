<?php
	class Copy
		{
		private $type;
		private $book_id;
		private $id;

		function __construct($type, $book_id, $id = null)
		{
			$this->type = $type;
			$this->book_id = $book_id;
			$this->id = $id;
		}

		function getType()
		{
			return $this->type;
		}

        function setType()
        {
            $this->type = $type;
        }

		function setBookId()
		{
			$this->book_id = $book_id;
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
            $GLOBALS['DB']->exec("INSERT INTO copies (type, book_id) VALUES ('{$this->getType()}', '{$this->getBookId()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies");
            $copies = array();
            foreach($returned_copies as $copy){
                 $type = $copy['type'];
                 $book_id = $copy['book_id'];
                 $id = $copy['id'];
                 $new_copy = new Copy($type, $book_id, $id);
                 array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies");
        }
	}
 ?>
