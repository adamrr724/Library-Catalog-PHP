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

	class CopyTest extends PHPUnit_Framework_TestCase
	{
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
            // Patron::deleteAll();
            // Copy::deleteAll();
        }

		function test_getters()
		{
            $test_title = "The Magicians";
			$id = 2;
			$test_book = new Book($test_title, $id);

            $test_type = "Hard Cover";
            $test_book_id = $test_book->getId();
			$id = 1;
			$test_copy = new Copy($test_type, $test_book_id, $id);

			$result1 = $test_copy->getType();
			$result2 = $test_copy->getBookId();
			$result3 = $test_copy->getId();

			$this->assertEquals("Hard Cover", $result1);
			$this->assertEquals(2, $result2);
			$this->assertEquals(1, $result3);

		}
	}

?>
