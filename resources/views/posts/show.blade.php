@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article>
        <p class="text-sm text-zinc-500">
            @if ($post->category)
                <a href="{{ route('categories.show', $post->category->slug) }}" class="font-medium text-zinc-700 hover:underline">
                    {{ $post->category->name }}
                </a>
                <span aria-hidden="true"> · </span>
            @endif
            <time datetime="{{ $post->published_at?->toDateString() }}">
                {{ $post->published_at?->format('M j, Y') }}
            </time>
            @if ($post->author)
                <span aria-hidden="true"> · </span>
                {{ $post->author->name }}
            @endif
        </p>

        <h1 class="mt-3 text-4xl font-semibold tracking-tight">{{ $post->title }}</h1>
        <p class="mt-4 text-lg text-zinc-600">{{ $post->excerpt }}</p>

        @if ($post->featuredImageUrl())
            <img src="{{ $post->featuredImageUrl() }}" alt="" class="mt-8 h-72 w-full rounded-lg object-cover">
        @endif

        <div class="prose mt-8 max-w-none text-zinc-800 [&_a]:underline [&_h2]:mt-8 [&_h2]:text-2xl [&_h2]:font-semibold [&_p]:mt-4 [&_p]:leading-7">
            {!! $post->body !!}
        </div>
    </article>
@endsection
