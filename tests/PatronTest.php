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
            Author::deleteAll();
            Patron::deleteAll();
            Copy::deleteAll();
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

        function test_save()
        {
            $test_name = "John Fisher";
			$id = null;
			$test_patron = new Patron($test_name, $id);
            $test_patron->save();

            $result = Patron::getAll();

            $this->assertEquals([$test_patron], $result);
        }

        function test_getAll()
        {
            $test_name = "John Fisher";
			$id = null;
			$test_patron = new Patron($test_name, $id);
            $test_patron->save();

            $test_name2 = "Paul Allen";
			$id = null;
			$test_patron2 = new Patron($test_name, $id);
            $test_patron2->save();

            $result = Patron::getAll();

            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function test_deleteAll()
        {
            $test_name = "John Fisher";
			$id = null;
			$test_patron = new Patron($test_name, $id);
            $test_patron->save();

            $test_name2 = "Paul Allen";
			$id = null;
			$test_patron2 = new Patron($test_name, $id);
            $test_patron2->save();

            Patron::deleteAll();

            $this->assertEquals([], Patron::getAll());
        }

        function test_find()
        {
            $test_name = "John Fisher";
			$id = null;
			$test_patron = new Patron($test_name, $id);
            $test_patron->save();

            $test_name2 = "Paul Allen";
			$id = null;
			$test_patron2 = new Patron($test_name, $id);
            $test_patron2->save();

            $result = Patron::find($test_patron->getId());

            $this->assertEquals($test_patron, $result);
        }
	}

?>
