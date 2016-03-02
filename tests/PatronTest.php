<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Patron.php";

//if using database
$server = 'mysql:host=localhost;dbname=library_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class  PatronTest  extends PHPUnit_Framework_TestCase{

  protected function teardown()
  {
      Patron::deleteAll();
  }

  function testGetLastName()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 1;
      $new_patron2 = new Patron($last_name, $first_name, $id);

      //act
      $results = $new_patron2->getLastName();

      //assert
      $this->assertEquals("Cooper", $results);
  }
  function testGetFirstName()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 1;
      $new_patron2 = new Patron($last_name, $first_name, $id);

      //act
      $results = $new_patron2->getFirstName();

      //assert
      $this->assertEquals("James", $results);
  }
  function testGetId()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 1;
      $new_patron2 = new Patron($last_name, $first_name, $id);

      //act
      $results = $new_patron2->getId();

      //assert
      $this->assertEquals(1, $results);
  }

  function testSave()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_patron2 = new Patron($last_name, $first_name, $id);

      //act
      $new_patron2->save();
      $result = Patron::getAll();

      //assert
      $this->assertEquals([$new_patron2], $result);
  }

  function testGetAll()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_patron = new Patron($last_name, $first_name, $id);
      $new_patron->save();

      $last_name2 = "Chernow";
      $first_name2 = "Ron";
      $id2 = 1;
      $new_patron2 = new Patron($last_name2, $first_name2, $id2);
      $new_patron2->save();

      //act
      $result = Patron::getAll();

      //assert
      $this->assertEquals([$new_patron, $new_patron2], $result);
  }

  function testDeleteAll()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_patron2 = new Patron($last_name, $first_name, $id);
      $new_patron2->save();

      $last_name2 = "Chernow";
      $first_name2 = "Ron";
      $id = 1;
      $new_patron2 = new Patron($last_name2, $first_name2, $id);
      $new_patron2->save();

      //act
      Patron::deleteAll();
      $result = Patron::getAll();

      //assert
      $this->assertEquals([], $result);
  }

  function testFind()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_patron2 = new Patron($last_name, $first_name, $id);
      $new_patron2->save();

      $last_name2 = "Chernow";
      $first_name2 = "Ron";
      $id2 = 1;
      $new_patron2 = new Patron($last_name2, $first_name2, $id2);
      $new_patron2->save();

      //act
      $result = Patron::find($new_patron2->getId());

      //assert
      $this->assertEquals($new_patron2, $result);
  }

  function testUpdateMem()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_patron2 = new Patron($last_name, $first_name, $id);
      $new_patron2->save();

      $new_first_name = "James Fenimore";
      $new_last_name = "Coop-star";

      //act
      $new_patron2->update($new_last_name, $new_first_name);

      //assert
      $this->assertEquals($new_patron2->getFirstName(), $new_first_name);

  }
  function testUpdateDB()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_patron2 = new Patron($last_name, $first_name, $id);
      $new_patron2->save();

      $new_first_name = "James Fenimore";
      $new_last_name = "Coop-star";

      //act
      $new_patron2->update($new_last_name, $new_first_name);
      $result = Patron::find($new_patron2->getId());

      //assert
      $this->assertEquals($result->getFirstName(), $new_first_name);

  }
  function testDelete()
  {
      //arrange
      $last_name = "Cooper";
      $first_name = "James";
      $id = 0;
      $new_patron = new Patron($last_name, $first_name, $id);
      $new_patron->save();

      $last_name2 = "Chernow";
      $first_name2 = "Ron";
      $id2 = 1;
      $new_patron2 = new Patron($last_name2, $first_name2, $id2);
      $new_patron2->save();

      //act
      $new_patron->delete();
      $result = Patron::getAll();

      //assert
      $this->assertEquals([$new_patron2], $result);

  }
}
?>
