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

	class BookTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Book::deleteAll();
			Author::deleteAll();
			Patron::deleteAll();
			// Copy::deleteAll();
		}

		function test_getters()
		{
			$test_title = "The Magicians";
			$id = 1;
			$test_book = new Book($test_title, $id);

			$result1 = $test_book->getTitle();
			$result2 = $test_book->getId();

			$this->assertEquals("The Magicians", $result1);
			$this->assertEquals(1, $result2);

		}

		function test_save()
	    {
			$test_title = "The Magicians";
			$id = null;
			$test_book = new Book($test_title, $id);
		    $test_book->save();

		    $result = Book::getAll();

		    $this->assertEquals([$test_book], $result);
	    }

		function test_getAll()
        {
			$test_title = "The Magicians";
			$id = null;
			$test_book = new Book($test_title, $id);
		    $test_book->save();

            $test_title2 = "Moby Dick";
            $test_book2 = new Book($test_title2, $id);
            $test_book2->save();

            $result = Book::getAll();

            $this->assertEquals([$test_book, $test_book2], $result);
        }

		function test_deleteAll()
        {
			$test_title = "The Magicians";
			$id = null;
			$test_book = new Book($test_title, $id);
		    $test_book->save();

            $test_title2 = "Moby Dick";
            $test_book2 = new Book($test_title2, $id);
            $test_book2->save();

            Book::deleteAll();

            $this->assertEquals([], Book::getAll());
        }

		function test_find()
		{
			$test_title = "The Magicians";
			$id = null;
			$test_book = new Book($test_title, $id);
		    $test_book->save();

            $test_title2 = "Moby Dick";
            $test_book2 = new Book($test_title2, $id);
            $test_book2->save();

			$result = Book::find($test_book->getId());

			$this->assertEquals($test_book, $result);
		}

		function test_update()
		{
			$test_title = "The Magicians";
			$id = null;
			$test_book = new Book($test_title, $id);
		    $test_book->save();

		    $new_title = "Science";

		    $test_book->update($new_title);

		   	$this->assertEquals($new_title, $test_book->getTitle());
		}

		function test_addAuthor()
		{
			$test_title = "The Magicians";
			$id = null;
			$test_book = new Book($test_title, $id);
		    $test_book->save();

			$first_name = "Lois";
			$last_name = "Lowry";
			$test_author = new Author($first_name, $last_name, $id);
			$test_author->save();

			$test_book->addAuthor($test_author);

			$this->assertEquals($test_book->getAuthors(), [$test_author]);
		}

		function test_getAuthors()
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

			$test_book->addAuthor($test_author);
			$test_book->addAuthor($test_author2);

			$this->assertEquals($test_book->getAuthors(), [$test_author, $test_author2]);
		}

    }

?>
