@extends('layouts.app')

@section('title', 'Ajouter un Parent')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">Ajouter un Parent</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guardians.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="block font-medium text-gray-700">Prénom</label>
                    <input type="text" name="first_name" id="first_name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block font-medium text-gray-700">Nom de famille</label>
                    <input type="text" name="last_name" id="last_name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block font-medium text-gray-700">Mot de passe</label>
                    <input type="password" name="password" id="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block font-medium text-gray-700">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block font-medium text-gray-700">Téléphone</label>
                    <input type="text" name="phone" id="phone" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('phone') }}" required>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block font-medium text-gray-700">Adresse</label>
                    <input type="text" name="address" id="address" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('address') }}">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block font-medium text-gray-700">Ville</label>
                    <input type="text" name="city" id="city" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('city') }}">
                    @error('city')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="student_ids" class="block font-medium text-gray-700">Élèves</label>
                    <select name="student_ids[]" id="student_ids" multiple class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ in_array($student->id, old('student_ids', [])) ? 'selected' : '' }}>{{ $student->full_name }}</option>
                        @endforeach
                    </select>
                    @error('student_ids')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 flex justify-end gap-4">
                <a href="{{ route('guardians.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">Annuler</a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection