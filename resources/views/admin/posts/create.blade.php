@extends('layouts.admin')

@section('title', 'New Post')
@section('page_title', 'New Post')

@section('content')
    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.posts._form', ['submitLabel' => 'Create Post'])
    </form>
@endsection
