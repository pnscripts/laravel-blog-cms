@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
    <h1 class="text-3xl font-semibold tracking-tight">Blog</h1>
    <p class="mt-2 text-zinc-600">Published posts, newest first.</p>

    <div class="mt-10 space-y-10">
        @forelse ($posts as $post)
            <article class="border-b border-zinc-200 pb-10 last:border-b-0">
                @if ($post->featuredImageUrl())
                    <a href="{{ route('posts.show', $post->slug) }}" class="mb-4 block overflow-hidden rounded-lg">
                        <img src="{{ $post->featuredImageUrl() }}" alt="" class="h-52 w-full object-cover">
                    </a>
                @endif

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
                </p>

                <h2 class="mt-2 text-2xl font-semibold tracking-tight">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:underline">{{ $post->title }}</a>
                </h2>
                <p class="mt-3 text-zinc-600">{{ $post->excerpt }}</p>
                <a href="{{ route('posts.show', $post->slug) }}" class="mt-4 inline-block text-sm font-medium text-zinc-900 hover:underline">
                    Read more
                </a>
            </article>
        @empty
            <p class="text-zinc-600">No published posts yet.</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
@endsection
