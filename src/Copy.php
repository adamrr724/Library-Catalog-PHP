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
	}
 ?>
