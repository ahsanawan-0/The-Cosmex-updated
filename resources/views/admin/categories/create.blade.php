@extends('layouts.admin')

@section('title', 'Create Category')
@section('page_title', 'Create Category')

@section('content')
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.categories._form', ['submitLabel' => 'Create Category'])
    </form>
@endsection
