@extends('layouts.admin')

<!-- Переопределяем хедер -->
@section('header')

    @include('admin.header')

@endsection

<!-- Переопределяем секцию content -->
@section('content')

    @include('admin.content_portfolio_add')

@endsection
