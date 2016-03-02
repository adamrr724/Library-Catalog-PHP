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
            // Author::deleteAll();
            // Patron::deleteAll();
            // Copy::deleteAll();
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
	}

?>
