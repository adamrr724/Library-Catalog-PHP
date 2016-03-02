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
	}

?>
