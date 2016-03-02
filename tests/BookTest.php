<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Book.php";

//if using database
$server = 'mysql:host=localhost;dbname=library_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class  BookTest  extends PHPUnit_Framework_TestCase{

  protected function teardown()
  {
      Book::deleteAll();
  }

  function testGetTitle()
  {
      //arrange
      $title = "Spy";
      $id = 1;
      $new_book = new Book($title, $id);

      //act
      $results = $new_book->getTitle();

      //assert
      $this->assertEquals("Spy", $results);
  }
  function testGetId()
  {
      //arrange
      $title = "Spy";
      $id = 1;
      $new_book = new Book($title, $id);

      //act
      $results = $new_book->getId();

      //assert
      $this->assertEquals(1, $results);
  }

  function testSave()
  {
      //arrange
      $title = "Spy";
      $id = 0;
      $new_book = new Book($title, $id);

      //act
      $new_book->save();
      $result = Book::getAll();

      //assert
      $this->assertEquals([$new_book], $result);
  }

  function testGetAll()
  {
      //arrange
      $title = "Spy";
      $id = 0;
      $new_book = new Book($title, $id);
      $new_book->save();

      $title2 = "Deerslayer";
      $id = 1;
      $new_book2 = new Book($title2, $id);
      $new_book2->save();

      //act
      $result = Book::getAll();

      //assert
      $this->assertEquals([$new_book, $new_book2], $result);
  }

  function testDeleteAll()
  {
      //arrange
      $title = "Spy";
      $id = 0;
      $new_book = new Book($title, $id);
      $new_book->save();

      $title2 = "Deerslayer";
      $id = 1;
      $new_book2 = new Book($title2, $id);
      $new_book2->save();

      //act
      Book::deleteAll();
      $result = Book::getAll();

      //assert
      $this->assertEquals([], $result);
  }

  function testFind()
  {
      //arrange
      $title = "Spy";
      $id = 0;
      $new_book = new Book($title, $id);
      $new_book->save();

      $title2 = "Deerslayer";
      $id2 = 1;
      $new_book2 = new Book($title2, $id2);
      $new_book2->save();

      //act
      $result = Book::find($new_book->getId());

      //assert
      $this->assertEquals($new_book, $result);
  }

  function testUpdateMem()
  {
      //arrange
      $title = "Spy";
      $id = 0;
      $new_book = new Book($title, $id);
      $new_book->save();

      $new_title = "Deerslayer";

      //act
      $new_book->update($new_title);

      //assert
      $this->assertEquals($new_book->getTitle(), $new_title);

  }
  function testUpdateDB()
  {
      //arrange
      $title = "Spy";
      $id = 0;
      $new_book = new Book($title, $id);
      $new_book->save();

      $new_title = "Coop-star";

      //act
      $new_book->update($new_title);
      $result = Book::find($new_book->getId());

      //assert
      $this->assertEquals($result->getTitle(), $new_title);

  }
  function testDelete()
  {
      //arrange
      $title = "Spy";
      $id = 0;
      $new_book = new Book($title, $id);
      $new_book->save();

      $title2 = "Deerslayer";
      $id = 1;
      $new_book2 = new Book($title2, $id);
      $new_book2->save();

      //act
      $new_book2->delete();
      $result = Book::getAll();

      //assert
      $this->assertEquals([$new_book], $result);

  }
}
?>