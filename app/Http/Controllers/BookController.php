<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Order;
use DateTime;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allBooks = [];
        //START Check if there is search query then gets books depending from that
        if($request->searchQuery) {
            $search = $request->searchQuery;
            $books = Book::where("title", "LIKE", "%$search%")->get();
            $authors = Author::where("name", "LIKE", "%$search%")->get();
            $allBooks = $books;
            //START Get books by author
            foreach($authors as $author) {
                $allBooksByAuthor = $author->book()->get();
                foreach($allBooksByAuthor as $book) {
                    //START Check if book is already added, if it's not then it needs to be added
                    $alreadyAddedBook = null;
                    foreach ($allBooks as $object) {
                        if ($object->id === $book->id) {
                            $alreadyAddedBook = $object;
                            break;
                        }
                    }
                    if($alreadyAddedBook == null) {
                        $allBooks->push($book);
                    }
                    //END Check if book is already added, if it's not then it needs to be added
                }
            }
            //END Get books by author
        } else {
            $allBooks = Book::all();
        }
        //END Check if there is search query then gets books depending from that

        //START Get books with ordersInLast30Days, allOrdersCount, authors properties
        $booksFormatted = [];
        foreach($allBooks as $book) {
            $newBookObject = $book;
            $allBookOrders = $book->orders()->get()->toArray();

            $thirtyDaysAgo = strtotime('-30 days');
            $ordersInLast30Days = array_filter($allBookOrders, function ($object) use ($thirtyDaysAgo) {
                $date = strtotime($object["order_date"]);
                return $date >= $thirtyDaysAgo;
            });
            $authors = array_map(function ($author) {
                return $author['name'];
            }, $book->authors()->get()->toArray());

            $newBookObject->all_orders_count = count($allBookOrders);
            $newBookObject->orders_in_last_30_Days = count($ordersInLast30Days);
            $newBookObject->authors = implode(",", $authors) ;
            array_push($booksFormatted, $newBookObject);
        }
        usort($booksFormatted, fn ($a, $b) => $b->orders_in_last_30_Days > $a->orders_in_last_30_Days);
        //END Get books with ordersInLast30Days, allOrdersCount, authors properties

        return view('books.index', compact('booksFormatted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
