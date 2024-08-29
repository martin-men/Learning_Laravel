{{-- CUANDO USABA layout.blade.php --}}

{{-- @extends('layout') --}}

{{-- En caso de haber otra sección en el layout con el nombre "banner", se la llenaría así
@section('banner')
    <h1>My blog</h1>
@endsection --}}

{{-- @section('content')
    @foreach ($posts as $post) --}}
{{-- Es posible acceder a propiedades de cada iteracion en un loop de blade, como el indice, si es par o impar, etc. --}}
{{-- <article class="{{ $loop->even ? 'foobar' : '' }}">
        <h1><a href="/post/{{ $post->slug }}">{{ $post->title }}</a></h1>
        <p>
            By <a href="/authors/{{ $post->author->username }}">{{ $post->author->name }}</a> in <a
                href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
        </p>
        <div>
            {{ $post->excerpt }}
        </div>
    </article>
    @endforeach
@endsection --}}

<x-layout-blade-component>
    <x-slot name="content">
        {{-- Para cargar archivos parciales blade (partials), se puede usar la directiva @include('ruta_del_archivo')
        "_" antes del nombre es una convención para indicar que es un archivo parcial
        Partials son archivos que contienen solo una parte de la vista y pueden acceder a variables de la vista principal
        Compononents son archivos que contienen una parte de la vista y una lógica aislada propia --}}
        @include('posts._header')

        <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
            @if ($posts->count() > 0)
                <x-posts-grid :posts="$posts" />

                {{-- This is available when you use ->paginate() instead of ->get() (look at the posts controller) --}}
                {{ $posts->links() }}
            @else
                <p class="text-center">No posts yet. Please check back later.</p>
            @endif
        </main>

        {{-- INITIAL APPROACH --}}
        {{-- @foreach ($posts as $post)
            <article class="{{ $loop->even ? 'foobar' : '' }}">
                <h1><a href="/post/{{ $post->slug }}">{{ $post->title }}</a></h1>
                <p>
                    By <a href="/authors/{{ $post->author->username }}">{{ $post->author->name }}</a> in <a
                        href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
                </p>
                <div>
                    {{ $post->excerpt }}
                </div>
            </article>
        @endforeach --}}
    </x-slot>
</x-layout-blade-component>
