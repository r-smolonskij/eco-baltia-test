<?php

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/topbooks', function (Request $request) {
    $thirtyDaysAgo = Carbon::now()->subDays(30);
    $topBooks = Order::select('book_id', DB::raw('COUNT(*) as orders_in_last_30_days'))
    ->where('order_date', '>=', $thirtyDaysAgo)
    ->groupBy('book_id')
    ->orderByDesc('orders_in_last_30_days')
    ->limit(10)
    ->get();
    $topBookIds = $topBooks->pluck('book_id')->toArray();

    $books = Book::whereIn('id', $topBookIds)->get();
    foreach ($books as $book) {
        $book->authors = $book->authors()->get();
        $bookId = $book->id;
        $book->orders_in_last_30_days = $topBooks->firstWhere('book_id', $bookId)->orders_in_last_30_days;
    }
    $sortedBooks = $books->sortBy(function ($book) {
        return -$book->orders_in_last_30_days;
    });

    return BookResource::collection($sortedBooks);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
