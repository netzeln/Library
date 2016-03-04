<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Patron.php";
    require_once __DIR__."/../src/Copy.php";



    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));
$app['debug'] = true;
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig');
    });
//LIBRARIAN
    $app->get("/librarian", function() use ($app){
        return $app['twig']->render('librarian.html.twig', array('all_authors'=>Author::getAll(), 'all_books'=>Book::getAll()));
    });
//cataloging
    $app->post("/add_book", function() use ($app){
        $new_book = new Book($_POST['title']);
        $new_book->save();
        //if author_exist is true
        if($_POST['exist_author'] != 'FALSE' && ($new_book->getId() !=0))
        {
            $result = Author::find($_POST['exist_author']);
            $new_book->add_author($result);
        }
      return $app['twig']->render('librarian.html.twig', array('all_authors'=>Author::getAll(), 'all_books'=>Book::getAll()));
    });
//get book edit page
    $app->get("/book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book.html.twig', array('book_authors' => $book->authors(), 'book' => $book, "all_authors"=>Author::getAll(), 'copies'=>$book->copies_list()));
    });
//edit title on book page
    $app->patch("/update_book/{id}", function($id) use ($app) {
        $new_title = $_POST['new_title'];
        $book = Book::find($id);
        $book->update($new_title);
        return $app['twig']->render('book.html.twig', array('book_authors' => $book->authors(), 'book' => $book, "all_authors"=>Author::getAll(), 'copies'=>$book->copies_list()));
    });

    $app->post("/add_author", function() use ($app){
        $new_author = new Author($_POST['author_last'], $_POST['author_first']);
        $new_author->save();
      return $app['twig']->render('librarian.html.twig', array('all_authors'=>Author::getAll(), 'all_books'=>Book::getAll()));

    });
//add additional authorship
    $app->post("/additional_author/{id}", function($id) use ($app){
        $book = Book::find($id);
        $all_authors = Author::getAll();
        //if author_exist is true

        if($_POST['exist_author'] != 'FALSE')
        {
            $result = Author::find($_POST['exist_author']);
            $book->add_author($result);
        } else
        {
            $new_author = new Author($_POST['author_last'], $_POST['author_first']);
            $new_author->save();

            $book->add_author($new_author);
        }

      return $app['twig']->render('book.html.twig', array('book_authors' => $book->authors(), 'book' => $book, 'all_authors'=> $all_authors, 'copies'=>$book->copies_list()));
    });

//delete book

    $app->delete("/delete/{id}", function($id) use ($app)
    {
        $banned_book = Book::find($id);
        $banned_book->delete();
      return $app['twig']->render('librarian.html.twig', array('all_authors'=>Author::getAll(), 'all_books'=>Book::getAll()));
    });

//book multiple copies
    $app->post("/add_copies/{id}", function($id) use ($app)
    {
        $book = Book::find($id);
        $book_id = $book->getId();
        $new_copy = new Copy($book_id);
        $amount = $_POST['add_book'];
        $counter = 1;
        while($counter <= $amount)
        {
            $new_copy->save();
            $counter++;
        }
        $copy = $book->copies();
        return $app['twig']->render('book.html.twig', array('copy_number' => $copy, 'book_authors' => $book->authors(), 'book' => $book, 'all_authors'=> Author::getAll(), 'copies'=>$book->copies_list()));
    });
//go to copy page
$app->get("/book/{id}/{copy_id}", function($id, $copy_id) use ($app) {
    $book = Book::find($id);
    $copy = Copy::find($copy_id);
    return $app['twig']->render('copy.html.twig', array('book_authors' => $book->authors(), 'book' => $book, "all_authors"=>Author::getAll(), 'copy'=>$copy, 'all_patrons'=> Patron::getAll(), 'copies'=>$book->copies_list()));
});
//book checkout
    $app->patch("/copy_checkout/{id}/{copy_id}", function($id, $copy_id) use ($app) {
        $book = Book::find($id);
        $due_date = $_POST['due_date'];
        $copy = Copy::find($copy_id);
        $patron = Patron::find($_POST['get_patron']);
        $copy->checkout($due_date, $patron);
        return $app['twig']->render('copy.html.twig', array('book_authors' => $book->authors(), 'book' => $book, "all_authors"=>Author::getAll(), 'copy'=>$copy, 'all_patrons'=> Patron::getAll(), 'copies'=>$book->copies_list()));
    });
    $app->patch("/copy_checkin/{id}/{copy_id}", function($id, $copy_id) use ($app) {
        $book = Book::find($id);
        $copy = Copy::find($copy_id);
        
        $copy->checkin();
        return $app['twig']->render('copy.html.twig', array('book_authors' => $book->authors(), 'book' => $book, "all_authors"=>Author::getAll(), 'copy'=>$copy, 'all_patrons'=> Patron::getAll(), 'copies'=>$book->copies_list()));
    });
//delete copy

    $app->delete("/delete/{id}/{copy_id}", function($id, $copy_id) use ($app)
    {
        $book = Book::find($id);
        $weeded_copy = Copy::find($copy_id);
        $weeded_copy->delete();
      return $app['twig']->render('book.html.twig', array('copy_number' => $copy, 'book_authors' => $book->authors(), 'book' => $book, 'all_authors'=> Author::getAll(), 'all_patrons'=> Patron::getAll(), 'copies'=>$book->copies_list()));
    });
///PATRONS
    $app->get("/patron", function() use ($app){
        return $app['twig']->render('patron.html.twig', array('all_patrons'=>Patron::getAll()));
    });
//add new Patron
    $app->post("/add_patron", function() use ($app){
        $new_patron = new Patron($_POST['patron_last'], $_POST['patron_first']);
        $new_patron->save();
      return $app['twig']->render('patron.html.twig', array('all_patrons'=>Patron::getAll()));
    });
//get Patron account page
    $app->get("/patron_id/login", function() use ($app) {
        $id = $_GET['get_patron'];
        $patron = Patron::find($id);
        return $app['twig']->render('patron_id.html.twig', array('patron' => $patron, 'copies' => $patron->getCheckouts()));
    });

    return $app;
 ?>
