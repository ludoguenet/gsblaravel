<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter une fiche frais') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('outpackage.store') }}" method="post">
                @csrf
                <x-input type="text" name="label" />
                <x-button type="submit">Enregistrer</x-button>
            </form>
        </div>
    </div>
</x-app-layout>
