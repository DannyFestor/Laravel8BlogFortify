@extends('layouts.app')

@section('content')
<section class="flex flex-col">
    <article class="mt-4">
        <h3 class="font-bold">{{ $post->title }}</h3>
        <p class="text-right">by {{ $post->user->name }}</p>
        <p>{{ $post->description }}</p>
        <a href="{{ route('posts.edit', $post->slug) }}">Edit Post</a>
    </article>
</section>
@endsection