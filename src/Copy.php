<?php
class Copy {

      private $book_id;
      private $available;
      private $due_date;
      private $id;

      function __construct($book_id, $available = 1, $due_date, $id = null)
      {
        $this->book_id = $book_id;
        $this->available = $available;
        $this->due_date = $due_date;
        $this->id = $id;
      }

      function getBookId()
      {
        return $this->book_id;
      }
      function getAvailable()
      {
          return $this->available;
      }
      function getDueDate()
      {
        return $this->due_date;
      }
      function getId()
      {
        return $this->id;
      }

      function setDueDate($new_due_date)
      {
        $this->due_date = $new_due_date;
      }
      function setBookId($new_book_id)
      {
        $this->book_id = $new_book_id;
      }
      function setAvailable($new_available)
      {
        $this->available = $new_available;
      }


      function save ()
      {
          $GLOBALS['DB']->exec("INSERT INTO copies (book_id, available, due_date) VALUES ({$this->getBookId()}, {$this->getAvailable()}, '{$this->getDueDate()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
      }

      static function getAll()
      {
          $found_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
          $copies = array();
          foreach($found_copies as $copy)
          {
              $book_id = $copy['book_id'];
              $available = $copy['available'];
              $due_date = $copy['due_date'];
              $id = $copy['id'];
              $new_copy = new Copy($book_id, $available, $due_date, $id);
              array_push($copies, $new_copy);
          }
          return $copies;
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE FROM copies;");
      }

    static function find($search_id)
    {
        $copies = Copy::getAll();
        $found_copy = null;
        foreach($copies as $copy)
        {
            if($search_id == $copy->getId())
            {
                $found_copy = $copy;
            }
        }
        return $found_copy;
    }

    function checkout($new_due_date)
    {
        $GLOBALS['DB']->exec("UPDATE copies SET available = 0, due_date ='{$new_due_date}' WHERE id = {$this->getId()};");
        $this->setAvailable(0);
        $this->setDueDate($new_due_date);
    }

    function checkin()
    {
        $GLOBALS['DB']->exec("UPDATE copies SET available = 1, due_date ='' WHERE id = {$this->getId()};");
        $this->setAvailable(1);
        $this->setDueDate('');
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");
    }

} ?>
