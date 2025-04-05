@extends('layouts.admin')

@section('pageTitle')
    Salons
@endsection

@section('admin-content')
    <div x-data="{ openModal: false, form: { name: '', permissions: [] } }" class="md:ml-64 pt-16 min-h-[100vh] container mx-auto px-4 py-8" x-cloak>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Gestion des salons</h1>
        </div>
    </div>
@endsection
