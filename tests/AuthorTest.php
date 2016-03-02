<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Author.php";

//if using database
$server = 'mysql:host=localhost;dbname=library_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class  AuthorTest  extends PHPUnit_Framework_TestCase{


  function testGetLastName()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 1;
      $new_author = new Author($last_name, $first_name, $id);

      //act
      $results = $new_author->getLastName();

      //assert
      $this->assertEquals("Cooper", $results);
  }
  function testGetFirstName()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 1;
      $new_author = new Author($last_name, $first_name, $id);

      //act
      $results = $new_author->getFirstName();

      //assert
      $this->assertEquals("James", $results);
  }
  function testGetId()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 1;
      $new_author = new Author($last_name, $first_name, $id);

      //act
      $results = $new_author->getId();

      //assert
      $this->assertEquals(1, $results);
  }

}
?>
