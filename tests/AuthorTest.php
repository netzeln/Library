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

  protected function teardown()
  {
      Author::deleteAll();
  }

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

  function testSave()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_author = new Author($last_name, $first_name, $id);

      //act
      $new_author->save();
      $result = Author::getAll();

      //assert
      $this->assertEquals([$new_author], $result);
  }

  function testGetAll()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_author = new Author($last_name, $first_name, $id);
      $new_author->save();

      $last_name2 = "Chernow";
      $first_name2 = "Ron";
      $id = 1;
      $new_author2 = new Author($last_name2, $first_name2, $id);
      $new_author2->save();

      //act
      $result = Author::getAll();

      //assert
      $this->assertEquals([$new_author, $new_author2], $result);
  }

  function testDeleteAll()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_author = new Author($last_name, $first_name, $id);
      $new_author->save();

      $last_name2 = "Chernow";
      $first_name2 = "Ron";
      $id = 1;
      $new_author2 = new Author($last_name2, $first_name2, $id);
      $new_author2->save();

      //act
      Author::deleteAll();
      $result = Author::getAll();

      //assert
      $this->assertEquals([], $result);
  }

  function testFind()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_author = new Author($last_name, $first_name, $id);
      $new_author->save();

      $last_name2 = "Chernow";
      $first_name2 = "Ron";
      $id2 = 1;
      $new_author2 = new Author($last_name2, $first_name2, $id2);
      $new_author2->save();

      //act
      $result = Author::find($new_author->getId());

      //assert
      $this->assertEquals($new_author, $result);
  }

  function testUpdateMem()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_author = new Author($last_name, $first_name, $id);
      $new_author->save();

      $new_first_name = "James Fenimore";
      $new_last_name = "Coop-star";

      //act
      $new_author->update($new_last_name, $new_first_name);

      //assert
      $this->assertEquals($new_author->getFirstName(), $new_first_name);

  }
  function testUpdateDB()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_author = new Author($last_name, $first_name, $id);
      $new_author->save();

      $new_first_name = "James Fenimore";
      $new_last_name = "Coop-star";

      //act
      $new_author->update($new_last_name, $new_first_name);
      $result = Author::find($new_author->getId());

      //assert
      $this->assertEquals($result->getFirstName(), $new_first_name);

  }
}
?>
