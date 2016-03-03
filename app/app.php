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
        $new_book->addCopy();
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

    $app->delete("/book/{id}/delete", function($id)use ($app) {
        $book = Book::find($id);
        $book->delete();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->post("/book/{id}/add_copy", function($id)use ($app) {
        $book = Book::find($id);
        $book->addCopy();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get("/authors", function() use ($app) {
       return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
   });

   $app->get("/authors/search", function() use ($app) {
       $search_term = $_GET['title'];
       $authors = Author::search($search_term);
       return $app['twig']->render('authors.html.twig', array('authors' => $authors));
   });

   $app->get("/authors/{id}/edit", function($id)use ($app) {
       $author = Author::find($id);
       return $app['twig']->render('authors_edit.html.twig', array('author' => $author));
   });

   $app->get("/author/{id}/addbook", function($id)use ($app) {
       $author = Author::find($id);
       return $app['twig']->render('author_addbook.html.twig', array('author' => $author));
   });

   $app->post("/author/{id}/addbook", function($id)use ($app) {
     $author = Author::find($id);
     $title = $_POST['title'];
     $new_book = new Book($title);
     $new_book->save();
     $author->addBook($new_book);
     $new_book->addCopy();
     return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
 });


   $app->patch("/author/{id}/edit_title", function($id)use ($app) {
       $first_name = $_POST['first_name'];
       $last_name = $_POST['last_name'];
       $author = Author::find($id);
       $author->updateFirstName($first_name);
       $author->updateLastName($last_name);
       return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
   });

   $app->delete("/author/{id}/delete", function($id)use ($app) {
       $author = Author::find($id);
       $author->delete();
       return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
   });

    $app->get("/patrons", function() use ($app) {
       return $app['twig']->render('sign_in.html.twig');
    });

    $app->get("/patron/{id}", function($id) use ($app) {
       $patron = Patron::find($id);
       $patrons = array();
       array_push($patrons, $patron);
       return $app['twig']->render('patron.html.twig', array('patrons' => $patrons));
    });

    $app->post("/patrons/add", function() use ($app) {
        $name = $_POST['name'];
        $patron = new Patron($name);
        $patron->save();
        $patrons = array();
        array_push($patrons, $patron);
       return $app['twig']->render('patron.html.twig', array('patrons' => $patrons));
    });

    $app->get("/patrons/search", function() use ($app) {
        $search_term = $_GET['name'];
        $patrons = Patron::search($search_term);
        return $app['twig']->render('patron.html.twig', array('patrons' => $patrons));
    });

    $app->delete("/patron/{id}/delete", function($id)use ($app) {
        $patron = Patron::find($id);
        $patron->delete();
        return $app['twig']->render('sign_in.html.twig');
    });

    $app->get("/patron/{id}/checkout", function($id) use ($app) {
       $patron = Patron::find($id);
       return $app['twig']->render('checkout_book.html.twig', array('patron' => $patron));
    });

    $app->get("/patron/{id}/books/search", function($id) use ($app) {
       $patron = Patron::find($id);
       $search_term = $_GET['title'];
       $books = Book::search($search_term);
       return $app['twig']->render('checkout_searchbook.html.twig', array('patron' => $patron,'books' => $books));
    });

    $app->get("/patron/{id}/authors/search", function($id) use ($app) {
       $patron = Patron::find($id);
       $search_term = $_GET['last_name'];
       $authors = Author::search($search_term);
       return $app['twig']->render('checkout_searchauthor.html.twig', array('patron' => $patron, 'authors' => $authors));
    });

    $app->get("/checkout/{id}", function($id) use ($app) {
       $book = Book::find($id);
       $patron_id = $_GET['patron_id'];
       $patron = Patron::find($patron_id);
       $book->checkout($patron_id);
       return $app['twig']->render('checked_out.html.twig', array('patron' => $patron, 'book' => $book));
    });

    $app->get("/patron/{id}/mybooks", function($id) use ($app) {
       $patron = Patron::find($id);
       $books = $patron->getPatronBooks();
       $all_books = Book::findCheckoutBooks($books);
       return $app['twig']->render('mybooks.html.twig', array('books' => $all_books, 'patron' => $patron));
    });




    return $app;

 ?>
