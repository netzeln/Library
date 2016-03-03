<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Copy.php";

//if using database
$server = 'mysql:host=localhost;dbname=library_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class  CopyTest  extends PHPUnit_Framework_TestCase{

  protected function teardown()
  {
      Copy::deleteAll();
  }

  function testGetBookId()
  {
      //arrange
      $book_id = 1;
      $available = 1;
      $due_date = NULL;
      $id = 0;
      $new_copy = new Copy($book_id, $available, $due_date, $id);

      //act
      $results = $new_copy->getBookId();

      //assert
      $this->assertEquals(1, $results);
  }
  function testGetAvailable()
  {
      //arrange
      $book_id = 1;
      $available = 1;
      $due_date = NULL;
      $id = 0;
      $new_copy = new Copy($book_id, $available, $due_date, $id);

      //act
      $results = $new_copy->getAvailable();

      //assert
      $this->assertEquals(1, $results);
  }
  function testGetDueDate()
  {
      //arrange
      $book_id = 1;
      $available = 0;
      $due_date = "2016-03-01";
      $id = 0;
      $new_copy = new Copy($book_id, $available, $due_date, $id);

      //act
      $results = $new_copy->getDueDate();

      //assert
      $this->assertEquals("2016-03-01", $results);
  }
  function testGetId()
  {
      //arrange
      $book_id = 1;
      $available = 0;
      $due_date = "2016-03-01";
      $id = 0;
      $new_copy = new Copy($book_id, $available, $due_date, $id);

      //act
      $results = $new_copy->getId();

      //assert
      $this->assertEquals(0, $results);
  }
  function testSave()
  {
      //arrange
      $book_id = 1;
      $available = 1;
      $due_date = '2016-03-01';
      $id = 0;
      $new_copy = new Copy($book_id, $available, $due_date, $id);

      //act
      $new_copy->save();
      $results = Copy::getAll();

      var_dump($new_copy);
      var_dump($results);

      //assert
      $this->assertEquals([$new_copy], $results);
  }
  // function testGetAll()
  // {
  //     //arrange
  //     $book_id = 1;
  //     $available = 0;
  //     $due_date = "2016-03-01";
  //     $id = 0;
  //     $new_copy = new Copy($book_id, $available, $due_date, $id);
  //
  //     $book_id2 = 2;
  //     $available2 = 0;
  //     $due_date2 = "2016-03-03";
  //     $id2 = 1;
  //     $new_copy2 = new Copy($book_id2, $available2, $due_date2, $id2);
  //
  //     //act
  //     $new_copy->save();
  //     $new_copy2->save();
  //     $results = Copy::getAll();
  //
  //     //assert
  //     $this->assertEquals([$new_copy, $new_copy2], $results);
  // }
  // function testDeleteAll()
  // {
  //     //arrange
  //     $book_id = 1;
  //     $available = 0;
  //     $due_date = "2016-03-01";
  //     $id = 0;
  //     $new_copy = new Copy($book_id, $available, $due_date, $id);
  //
  //     $book_id2 = 2;
  //     $available2 = 0;
  //     $due_date2 = "2016-03-03";
  //     $id2 = 1;
  //     $new_copy2 = new Copy($book_id2, $available2, $due_date2, $id2);
  //
  //     //act
  //     Copy::deleteAll();
  //     $results = Copy::getAll();
  //
  //     //assert
  //     $this->assertEquals([], $results);
  // }
  // function testFind()
  // {
  //     //arrange
  //     $book_id = 1;
  //     $available = 0;
  //     $due_date = "2016-03-01";
  //     $id = 0;
  //     $new_copy = new Copy($book_id, $available, $due_date, $id);
  //     $new_copy->save();
  //
  //     $book_id2 = 2;
  //     $available2 = 0;
  //     $due_date2 = "2016-03-03";
  //     $id2 = 1;
  //     $new_copy2 = new Copy($book_id2, $available2, $due_date2, $id2);
  //     $new_copy2->save();
  //
  //     //act
  //     $results = Copy::find($new_copy->getId());
  //
  //     //assert
  //     $this->assertEquals($new_copy, $results);
  // }
  // function testCheckout()
  // {
  //     //arrange
  //     $book_id = 1;
  //     $available = 1;
  //     $due_date = NULL;
  //     $id = 0;
  //     $new_copy = new Copy($book_id, $available, $due_date, $id);
  //     $new_copy->save();
  //     $new_due_date = "2016-04-04";
  //
  //     //act
  //     $new_copy->checkout($new_due_date);
  //     $results = Copy::getAll();
  //     var_dump($new_copy);
  //     var_dump($results);
  //
  //     //assert
  //     $this->assertEquals([$new_copy], $results);
  // }
  // function testCheckIn()
  // {
  //     //arrange
  //     $book_id = 1;
  //     $available = 0;
  //     $due_date = "2016-04-04";
  //     $id = 0;
  //     $new_copy = new Copy($book_id, $available, $due_date, $id);
  //     $new_copy->save();
  //
  //     //act
  //     $new_copy->checkin();
  //     $results = Copy::getAll();
  //
  //     //assert
  //     $this->assertEquals([$new_copy], $results);
  // }
  //
  //
  //
  //
  // function testDelete()
  // {
  //     //arrange
  //     $last_name = "Cooper";
  //     $first_name = "James";
  //     $id = 0;
  //     $new_author = new Copy($last_name, $first_name, $id);
  //     $new_author->save();
  //
  //     $last_name2 = "Chernow";
  //     $first_name2 = "Ron";
  //     $id = 1;
  //     $new_author2 = new Copy($last_name2, $first_name2, $id);
  //     $new_author2->save();
  //
  //     //act
  //     $new_author2->delete();
  //     $result = Copy::getAll();
  //
  //     //assert
  //     $this->assertEquals([], $result);
  // }
}
?>
