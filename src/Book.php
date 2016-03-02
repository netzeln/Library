<?php
class Book {

      private $title;
      private $id;

      function __construct($title, $id = null)
      {
        $this->title = $title;
        $this->id = $id;
      }

      function getTitle()
      {
        return $this->title;
      }
      function getId()
      {
        return $this->id;
      }
      function setTitle($new_title)
      {
        $this->title = $new_title;
      }

      function save ()
      {
          $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
      }

      static function getAll()
      {
          $found_books = $GLOBALS['DB']->query("SELECT * FROM books;");
          $books = array();
          foreach($found_books as $book)
          {
              $title = $book['title'];
              $id = $book['id'];
              $new_book = new Book($title, $id);
              array_push($books, $new_book);
          }
          return $books;
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE FROM books;");
      }

    static function find($search_id)
    {
        $books = Book::getAll();
        $found_book = null;
        foreach($books as $book)
        {
            if($search_id == $book->getId())
            {
                $found_book = $book;
            }
        }
        return $found_book;
    }

    function update($new_title)
    {
        $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()}; ");
        $this->setTitle($new_title);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
    }

} ?>
