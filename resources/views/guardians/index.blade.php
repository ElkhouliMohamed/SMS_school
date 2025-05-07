@extends('layouts.app')

@section('title', 'Parents')

@section('content')
    <div class="w-full flex flex-col gap-6">
        <!-- Header -->
        <div class="bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">Parents</h1>
            <a href="{{ route('guardians.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Ajouter un Parent
            </a>
        </div>

        <!-- Guardians Table -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des Parents</h2>
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Nom</th>
                            <th class="py-3 px-6 text-left">Téléphone</th>
                            <th class="py-3 px-6 text-left">Élèves</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse ($guardians as $guardian)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $guardian->first_name }} {{ $guardian->last_name }}</td>
                                <td class="py-3 px-6 text-left">{{ $guardian->phone ?? 'Aucun' }}</td>
                                <td class="py-3 px-6 text-left">
                                    {{ $guardian->students->pluck('first_name')->join(', ') ?: 'Aucun' }}
                                </td>
                                <td class="py-3 px-6 text-center flex justify-center gap-2">
                                    <a href="{{ route('guardians.show', $guardian) }}"
                                       class="text-indigo-600 hover:text-indigo-800"
                                       title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('guardians.edit', $guardian) }}"
                                       class="text-blue-600 hover:text-blue-800"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('guardians.destroy', $guardian) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800"
                                                title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce parent ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-3 px-6 text-center text-gray-500" colspan="4">
                                    Aucun parent trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $guardians->links() }}
            </div>
        </div>
    </div>
@endsection