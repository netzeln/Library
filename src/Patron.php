<?php
class Patron {

      private $last_name;
      private $first_name;
      private $id;

      function __construct($last_name, $first_name, $id = null)
      {
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->id = $id;
      }

      function getLastName()
      {
        return $this->last_name;
      }
      function getFirstName()
      {
        return $this->first_name;
      }
      function getId()
      {
        return $this->id;
      }

      function setFirstName($new_first_name)
      {
        $this->first_name = $new_first_name;
      }
      function setLastName($new_last_name)
      {
        $this->last_name = $new_last_name;
      }


      function save ()
      {
          $GLOBALS['DB']->exec("INSERT INTO patrons (last_name, first_name) VALUES ('{$this->getLastName()}', '{$this->getFirstName()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
      }

      static function getAll()
      {
          $found_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
          $patrons = array();
          foreach($found_patrons as $patron)
          {
              $last_name = $patron['last_name'];
              $first_name = $patron['first_name'];
              $id = $patron['id'];
              $new_patron = new Patron($last_name, $first_name, $id);
              array_push($patrons, $new_patron);
          }
          return $patrons;
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE FROM patrons;");
      }

    static function find($search_id)
    {
        $patrons = Patron::getAll();
        $found_patron = null;
        foreach($patrons as $patron)
        {
            if($search_id == $patron->getId())
            {
                $found_patron = $patron;
            }
        }
        return $found_patron;
    }

    function update($new_last_name, $new_first_name)
    {
        $GLOBALS['DB']->exec("UPDATE patrons SET last_name = '{$new_last_name}', first_name ='{$new_first_name}' WHERE id = {$this->getId()}; ");
        $this->setLastName($new_last_name);
        $this->setFirstName($new_first_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
    }

} ?>
