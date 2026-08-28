@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <p class="text-sm font-medium text-zinc-500">Category</p>
    <h1 class="mt-1 text-3xl font-semibold tracking-tight">{{ $category->name }}</h1>
    @if ($category->description)
        <p class="mt-2 text-zinc-600">{{ $category->description }}</p>
    @endif

    <div class="mt-10 space-y-10">
        @forelse ($posts as $post)
            <article class="border-b border-zinc-200 pb-10 last:border-b-0">
                <p class="text-sm text-zinc-500">
                    <time datetime="{{ $post->published_at?->toDateString() }}">
                        {{ $post->published_at?->format('M j, Y') }}
                    </time>
                </p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:underline">{{ $post->title }}</a>
                </h2>
                <p class="mt-3 text-zinc-600">{{ $post->excerpt }}</p>
            </article>
        @empty
            <p class="text-zinc-600">No published posts in this category yet.</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
@endsection
