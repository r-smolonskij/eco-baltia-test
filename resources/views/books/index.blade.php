@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
        <h1 class="mb-5">Grāmatu saraksts</h1>
        <div class="col-md-10 mb-5">
            <form action="{{ route('books') }}" method="GET" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="searchQuery"
                        placeholder="Meklēt grāmatas vai autorus"> <span class="input-group-btn">
                        <button type="submit" class="btn btn-success">
                            <span>Meklēt</span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        @if(session()->has('successMessage'))
        <div class="col-md-10 alert  alert-success alert-dismissible fade show" role="alert">
            <strong> {{ session('successMessage') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if(session()->has('errorMessage'))
        <div class="col-md-10 alert  alert-danger alert-dismissible fade show" role="alert">
            <strong> {{ session('errorMessage') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="col-md-10">
            <div class="card">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">#</th>
                            <th scope="col">Grāmatas nosaukums</th>
                            <th scope="col">Autorus saraksts</th>
                            <th scope="col">Kopējais pirkumu skaits</th>
                            <th scope="col">Pirkumi pēdējās 30 dienā</th>
                            <th scope="col">Pievienot pirkumu</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booksFormatted as $index=>$book)
                        <tr class="text-center">
                            <th>{{$index + 1}}</th>
                            <td>{{$book->title}}</td>
                            <td>{{$book->authors}}</td>
                            <td>{{$book->all_orders_count}}</td>
                            <td>{{$book->orders_in_last_30_Days}}</td>
                            <td>
                                <form action="{{ route('orders.store') }}" method="POST">
                                    @csrf
                                    <input type="number" name="bookId" class="d-none" value="{{$book->id}}">
                                    <button type="submit" class="btn btn-success">Pievienot</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection