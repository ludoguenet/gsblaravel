<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter une fiche frais') }}
        </h2>
    </x-slot>

        @if(session()->has('success'))
            <x-alert :message="session('success')" type="success" />
        @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-xl font-bold">Frais forfaitisés</h1>
            <form action="{{ route('report.update', ['report' => $expenseReport]) }}" method="post" class="space-y-2">
                @method('put')
                @csrf
                @foreach ($expenseReport->fees as $fee)
                    <x-label value="{{ $fee->type->label }}" />
                    <x-input type="text" name="fees[{{ $fee->type->id }}]" value="{{ $fee->amount }}" class="w-full"/>
                @endforeach
                <x-button type="submit">Enregistrer</x-button>
            </form>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-xl font-bold">Frais non forfaitisés</h1>
            <form action="{{ route('expenseReports.extraFees.store', $expenseReport) }}" method="post" class="space-y-2">
                @csrf
                <x-label value="Libellé" />
                <x-input type="text" name="label" class="w-full"/>
                <x-label value="Montant" />
                <x-input type="text" name="amount" class="w-full"/>
                <x-button type="submit">Enregistrer</x-button>
            </form>
        </div>
    </div>
</x-app-layout>
