@extends('layouts.app')

@section('body')
    <main class="min-h-screen flex items-center justify-center p-margin-mobile md:p-margin-desktop bg-surface">
        @yield('content')
    </main>
@endsection