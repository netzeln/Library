<?php
class Author {

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
          $GLOBALS['DB']->exec("INSERT INTO authors (last_name, first_name) VALUES ('{$this->getLastName()}', '{$this->getFirstName()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
      }

      static function getAll()
      {
          $found_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
          $authors = array();
          foreach($found_authors as $author)
          {
              $last_name = $author['last_name'];
              $first_name = $author['first_name'];
              $id = $author['id'];
              $new_author = new Author($last_name, $first_name, $id);
              array_push($authors, $new_author);
          }
          return $authors;
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE FROM authors;");
      }

    static function find($search_id)
    {
        $authors = Author::getAll();
        $found_author = null;
        foreach($authors as $author)
        {
            if($search_id == $author->getId())
            {
                $found_author = $author;
            }
        }
        return $found_author;
    }


} ?>
