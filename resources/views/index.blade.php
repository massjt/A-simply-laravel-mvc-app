@extends('layouts.master')

@section('title')
Trending quotes
@endsection

@section('styles')
    <link href="http://cdn.bootcss.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet">
@endsection

@section('content')
    @if(!empty(Request::segment(1)))
        <section class="filter-bar">
            A filter has been set! <a href="{{ route('index') }}">show all quotes</a>
        </section>
    @endif

    @if (count($errors) > 0)
        <section class="info-box fail">
            <ul>
                @foreach($errors->all() as $error)
                    {{$error}}
                @endforeach
            </ul>
        </section>
    @endif
    @if(Session::has('success'))
        <section class="info-box success">
            {{ Session::get('success') }}
        </section>
    @endif
    <section class="quotes">
        <h1>Latest  quotes</h1>
        @for($i = 0; $i < count($quotes); $i++)
            <article class="quote">
                <div class="delete">
                    <a href="{{ route('delete',['quote_id' => $quotes[$i]->id]) }}">x</a>
                </div>
                {{ $quotes[$i]->quote }}
                <div class="info">Created By <a href="{{ route('index',['author' => $quotes[$i]->author->name]) }}"> {{ $quotes[$i]->author->name }} </a> on {{ $quotes[$i]->created_at }}</div>
                {{-- <div class="info">Created By <a href="{{ route('profile',['author_id' => $quotes[$i]->author->id]) }}"> {{ $quotes[$i]->author->name }} </a> on {{ $quotes[$i]->created_at }}</div> --}}
            </article>
        @endfor
       <div class="pagination">
       @if ($quotes->currentPage() !== 1)
            <a href="{{ $quotes->previousPageUrl() }}">
                <span class="fa fa-caret-left"></span>
            </a>
       @endif
       @if ($quotes->currentPage() !== $quotes->lastPage() && $quotes->hasPages())
            <a href="{{ $quotes->nextPageUrl() }}">
                <span class="fa fa-caret-right"></span>
            </a>
       @endif
       </div>
    </section>
    <section class="edit-quotes">
        <h1>Add a quotes</h1>
        <form  action="{{ route('create') }}" method="post">
            <div class="input-group">
                <label for="author">Your Name</label>
                <input type="text" name="author" id="author" placeholder="Your Name">
            </div>
            <div class="input-group">
                <label for="email">Your email</label>
                <input type="email" name="email" id="email" placeholder="Your email">
            </div>
            <div class="input-group">
                <label for="quote">Your quote</label>
                <textarea name="quote" id="quote" placeholder="Quote" rows="5"></textarea>
                <button type="submit" class="btn">submit Quote</button>
                {{ csrf_field() }}
            </div>
        </form>
    </section>
@endsection