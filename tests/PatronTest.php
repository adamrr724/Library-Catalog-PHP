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

	class PatronTest extends PHPUnit_Framework_TestCase
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
			$test_name = "John Fisher";
			$id = 1;
			$test_patron = new Patron($test_name, $id);

			$result1 = $test_patron->getName();
			$result2 = $test_patron->getId();

			$this->assertEquals("John Fisher", $result1);
			$this->assertEquals(1, $result2);

		}
	}

?>
