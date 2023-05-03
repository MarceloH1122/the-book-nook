@extends('layouts.main', ['main_width' => '-webkit-fill-available'])
@php
    
    use App\Models\Book;
    use App\Models\Author;
    use App\Models\Publisher;
    use App\Models\Genre;
    // use App\Models\{
    //     Book,
    // Genre,
    // Author,
    // Publisher
    // };
@endphp
@section('title', "Search: $search_input")
@section('content')
    @php
        $books = $checked_book ? Book::where('title', 'LIKE', '%' . $search_input . '%')->paginate(30) : [];
        $genres = $checked_author ? Genre::where('name', 'LIKE', '%' . $search_input . '%')->paginate(30) : [];
        $authors = $checked_genre ? Author::where('name', 'LIKE', '%' . $search_input . '%')->paginate(30) : [];
        $publishers = $checked_publisher ? Publisher::where('name', 'LIKE', '%' . $search_input . '%')->paginate(30) : [];
        

        $arrays = ['genres' => $genres, 'authors' => $authors, 'publishers' => $publishers];
    @endphp

    @if ($checked_book)
        <h2>Books</h2>
        <section class="p-2 p-md-5 w-fill">
            @include('layouts.book.book-collection-expanded', [
                'collection' => $books,
            ])
        </section>
    @endif

    @foreach ($arrays as $name => $collection)
        @unless ($$name)
            @continue
        @endunless

        <h2>{{ ucwords($name) }}</h2>
        <section class="p-2 p-md-5 pt-md-2 w-fill">
            @forelse ($collection as $element)
                <a class="text-decoration-none fw-normal"
                    href="/details/{{ rtrim($name, 's') }}/{{ $element->id }}">{{ $element->name }}</a><br>
            @empty
                @include('layouts.util.nothing')
            @endforelse
        </section>
    @endforeach
    </ul>
@endsection
