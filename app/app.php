<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Patron.php";
    require_once __DIR__."/../src/Copy.php";

    // session_start();
    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $server = 'mysql:host=localhost;dbname=library_catalog';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

     $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get("/books/search", function() use ($app) {
        $search_term = $_GET['title'];
        $books = Book::search($search_term);
        return $app['twig']->render('books.html.twig', array('books' => $books));
    });

    $app->get("/books/add", function() use ($app) {
        return $app['twig']->render('books_add.html.twig');
    });

    $app->post("/books/addbook", function() use ($app) {
        $title = $_POST['title'];
        $new_book = new Book($title);
        $new_book->save();
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $new_author = new Author($first_name, $last_name);
        $new_author->save();
        $new_book->addAuthor($new_author);
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get("/books/{id}/edit", function($id)use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('books_edit.html.twig', array('book' => $book));
    });

    $app->patch("/book/{id}/edit_title", function($id)use ($app) {
        $title = $_POST['title'];
        $book = Book::find($id);
        $book->update($title);
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->patch("/book/{id}/add_author", function($id)use ($app) {
        $book = Book::find($id);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $new_author = new Author($first_name, $last_name);
        $new_author->save();
        $book->addAuthor($new_author);
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get("/authors", function() use ($app) {
       return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
   });

    return $app;

 ?>
