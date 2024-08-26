@extends('layout')

{{-- En caso de haber otra sección en el layout con el nombre "banner", se la llenaría así
@section('banner')
    <h1>My blog</h1>
@endsection --}}

@section('content')
    @foreach ($posts as $post)
        {{-- Es posible acceder a propiedades de cada iteracion en un loop de blade, como el indice, si es par o impar, etc. --}}
        <article class="{{ $loop->even ? 'foobar' : '' }}">
            <h1><a href="/post/{{ $post->slug }}">{{ $post->title }}</a></h1>
            <p>
                <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
            </p>
            <div>
                {{ $post->excerpt }}
            </div>
        </article>
    @endforeach
@endsection
