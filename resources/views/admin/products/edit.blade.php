@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product')

@section('content')
    <form method="POST" action="{{ route('admin.products.update', data_get($product, 'id')) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products._form', ['submitLabel' => 'Update Product'])
    </form>
@endsection
