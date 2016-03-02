<?php

	require_once 'src/Author.php';

	class AuthorTest extends PHPUnit_Framework_TestCase
	{

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
