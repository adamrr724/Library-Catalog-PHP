<?php

	require_once 'src/Patron.php';

	class PatronTest extends PHPUnit_Framework_TestCase
	{

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
