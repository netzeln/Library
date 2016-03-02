<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Patron.php";



    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig');
    });
//LIBRARIAN
    $app->get("/librarian", function() use ($app){
        return $app['twig']->render('librarian.html.twig', array('all_authors'=>Author::getAll(), 'all_books'=>Book::getAll()));
    });
//cataloging
    $app->post("/add_book", function() use ($app){
        $new_book = new Book ($_POST['title']);
        $new_book->save();
        //if author_exist is true
      return $app['twig']->render('librarian.html.twig', array('all_authors'=>Author::getAll(), 'all_books'=>Book::getAll()));

    });

    $app->post("/add_author", function() use ($app){
        $new_author = new Author($_POST['author_last'], $_POST['author_first']);
        $new_author->save();
      return $app['twig']->render('librarian.html.twig', array('all_authors'=>Author::getAll(), 'all_books'=>Book::getAll()));

    });




    $app->get("/patron", function() use ($app){
        return $app['twig']->render('patron.html.twig');
    });


    return $app;
 ?>
