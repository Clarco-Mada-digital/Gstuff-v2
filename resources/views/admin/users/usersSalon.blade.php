@extends('layouts.admin')

@section('pageTitle')
    Salons
@endsection

@section('admin-content')
    <div x-data="{ openModal: false, form: { name: '', permissions: [] } }" class="container mx-auto min-h-[100vh] px-4 py-8 pt-16 md:ml-64" x-cloak>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Gestion des salons</h1>
        </div>
    </div>
@endsection
