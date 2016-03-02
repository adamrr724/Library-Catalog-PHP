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

		function setFirstName($new_first_name)
		{
			$this->first_name = $new_first_name;
		}

        function getLastName()
		{
			return $this->last_name;
		}

		function setLastName($new_last_name)
		{
			$this->last_name = $new_last_name;
		}

		function getId()
		{
			return $this->id;
		}

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (first_name, last_name) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors");
            $authors = array();
            foreach($returned_authors as $author){
                 $first_name = $author['first_name'];
                 $last_name = $author['last_name'];
                 $id = $author['id'];
                 $new_author = new Author($first_name, $last_name, $id);
                 array_push($authors, $new_author);
            }
            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors");
        }

        // FIND A SPECIFIC AUTHOR BY ID
        static function find($id)
        {
            $all_authors = Author::getAll();
            $found_author = null;
            foreach($all_authors as $author) {
                $author_id = $author->getId();
                if ($author_id == $id) {
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        function updateFirstName($new_first_name)
        {
           $GLOBALS['DB']->exec("UPDATE authors SET first_name = '{$new_first_name}' WHERE id={$this->getId()};");
           $this->setFirstName($new_first_name);
        }

        function updateLastName($new_last_name)
        {
           $GLOBALS['DB']->exec("UPDATE authors SET last_name = '{$new_last_name}' WHERE id={$this->getId()};");
           $this->setLastName($new_last_name);
        }

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (author_id, book_id) VALUES ({$this->getId()}, {$book->getId()}) ;");
        }

        function getBooks()
        {
            $query = $GLOBALS['DB']->query("SELECT books.* FROM authors JOIN books_authors ON (authors.id = books_authors.author_id) JOIN books ON (books_authors.book_id = books.id) WHERE authors.id = {$this->getId()}; ");
            $returned_books = $query->fetchAll(PDO::FETCH_ASSOC);
            $books = array();
            foreach($returned_books as $book){
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push( $books, $new_book);
            }
            return $books;
        }
	}
 ?>
