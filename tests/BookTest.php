<?php

	require_once 'src/Book.php';

	class BookTest extends PHPUnit_Framework_TestCase
	{

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
	}

?>
