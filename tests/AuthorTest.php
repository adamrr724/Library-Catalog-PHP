<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Book.php';
    require_once 'src/Author.php';
    require_once 'src/Patron.php';
    require_once 'src/Copy.php';

    $server = 'mysql:host=localhost;dbname=library_catalog_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

	class AuthorTest extends PHPUnit_Framework_TestCase
	{
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
            Patron::deleteAll();
            Copy::deleteAll();
        }

		function test_getters()
		{
			$first_name = "Lois";
			$last_name = "Lowry";
			$id = 1;
			$test_author = new Author($first_name, $last_name, $id);

			$result1 = $test_author->getFirstName();
			$result2 = $test_author->getLastName();
			$result3 = $test_author->getId();

			$this->assertEquals("Lois", $result1);
			$this->assertEquals("Lowry", $result2);
			$this->assertEquals(1, $result3);

		}

        function test_save()
        {
            $first_name = "Lois";
			$last_name = "Lowry";
			$id = 1;
			$test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $result = Author::getAll();

            $this->assertEquals([$test_author], $result);
        }

        function test_getAll()
        {
            $first_name = "Lois";
			$last_name = "Lowry";
			$id = null;
			$test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = "Henry David";
			$last_name2 = "Thoreau";
			$test_author2 = new Author($first_name2, $last_name2, $id);
            $test_author2->save();

            $result = Author::getAll();

            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_deleteAll()
        {
            $first_name = "Lois";
			$last_name = "Lowry";
			$id = null;
			$test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = "Henry David";
			$last_name2 = "Thoreau";
			$test_author2 = new Author($first_name2, $last_name2, $id);
            $test_author2->save();

            Author::deleteAll();

            $this->assertEquals([], Author::getAll());
        }

        function test_find()
        {
            $first_name = "Lois";
			$last_name = "Lowry";
			$id = null;
			$test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = "Henry David";
			$last_name2 = "Thoreau";
			$test_author2 = new Author($first_name2, $last_name2, $id);
            $test_author2->save();

            $result = Author::find($test_author->getId());

            $this->assertEquals($test_author, $result);
        }

        function test_updateFirst()
        {
            $first_name = "Lois";
            $last_name = "Lowry";
            $id = null;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $new_first_name = "Jane";

            $test_author->updateFirstName($new_first_name);

            $this->assertEquals($new_first_name, $test_author->getFirstName());
        }

        function test_updateLast()
        {
            $first_name = "Lois";
            $last_name = "Lowry";
            $id = null;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $new_last_name = "Fonda";

            $test_author->updateLastName($new_last_name);

            $this->assertEquals($new_last_name, $test_author->getLastName());
        }

        function test_addBook()
        {
            $test_title = "The Magicians";
            $id = null;
            $test_book = new Book($test_title, $id);
            $test_book->save();

            $first_name = "Lois";
            $last_name = "Lowry";
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $test_author->addBook($test_book);

            $this->assertEquals($test_author->getBooks(), [$test_book]);
        }

        function test_getBooks()
        {
            $test_title = "The Magicians";
            $id = null;
            $test_book = new Book($test_title, $id);
            $test_book->save();

            $first_name = "Lois";
            $last_name = "Lowry";
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $test_title2 = "Moby Dick";
            $test_book2 = new Book($test_title2, $id);
            $test_book2->save();

            $first_name2 = "Henry David";
            $last_name2 = "Thoreau";
            $test_author2 = new Author($first_name2, $last_name2, $id);
            $test_author2->save();

            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);
        }
	}

?>
