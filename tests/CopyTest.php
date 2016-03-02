<?php

	require_once 'src/Copy.php';
	require_once 'src/Book.php';

	class CopyTest extends PHPUnit_Framework_TestCase
	{

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
