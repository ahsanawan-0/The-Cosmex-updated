@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page_title', 'Edit Category')

@section('content')
    <form method="POST" action="{{ route('admin.categories.update', data_get($category, 'id')) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['submitLabel' => 'Update Category'])
    </form>
@endsection
