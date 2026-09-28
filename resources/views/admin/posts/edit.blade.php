@extends('layouts.admin')

@section('title', 'Edit Post')
@section('page_title', 'Edit Post')

@section('content')
    <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.posts._form', ['submitLabel' => 'Save Post'])
    </form>
@endsection
