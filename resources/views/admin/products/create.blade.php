@extends('layouts.admin')

@section('title', 'Create Product')
@section('page_title', 'Create Product')

@section('content')
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form', ['submitLabel' => 'Create Product'])
    </form>
@endsection
