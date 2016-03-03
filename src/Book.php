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
        $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
        $this->setTitle($new_title);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM authorship WHERE book_id = {$this->getId()};");
    }

    function add_author($new_author)
    {
        $GLOBALS['DB']->exec("INSERT INTO authorship (book_id, author_id) VALUES ({$this->getId()}, {$new_author->getID()});");
    }

    function authors()
    {
        $matching_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books
                            JOIN authorship ON (books.id = authorship.book_id)
                            JOIN authors ON (authorship.author_id = authors.id)
                            WHERE books.id = {$this->getId()};");
        $authors = array();
        foreach($matching_authors as $author)
        {
            $last_name = $author['last_name'];
            $first_name = $author['first_name'];
            $id = $author['id'];
            $new_author = new Author($last_name, $first_name, $id);
            array_push($authors, $new_author);
        }
        return $authors;
    }

    function add_copy($new_copy)
    {
        $GLOBALS['DB']->exec("INSERT INTO copies (book_id, available, due_date) VALUES ({$this->getId()}, {$new_copy->getAvailable()}, {$new_copy->getDueDate});");
    }

    function copies()
    {
        $matching_copies = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$this->getId()};");
        $copies = array();
        foreach($matching_copies as $copy)
        {
            $book_id = $copy['book_id'];
            $available = $copy['available'];
            $due_date = $copy['due_date'];
            $id = $copy['id'];
            $new_copy = new Copy($book_id, $available, $due_date, $id);
            array_push($copies, $new_copy);
        }
        return count($copies);
    }

} ?>
