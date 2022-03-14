<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter une fiche frais') }}
        </h2>
    </x-slot>

    @if(session()->has('errors'))
    @foreach ($errors->all() as $error)
    {{ $error }}
    @endforeach
    @endif

    @if(session()->has('success'))
    <x-alert :message="session('success')" type="success" />
    @endif

    <form action="{{ route('expenseReports.extraFees.store', $expenseReport) }}" method="post">
        @csrf
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-xl font-bold mb-5">Frais forfaitisés</h1>
                <div class="space-y-2">
                    @foreach ($expenseReport->fees as $fee)
                    <x-label value="{{ $fee->type->label }}" />
                    <x-input type="text" name="fees[{{ $fee->type->id }}]" value="{{ $fee->quantity }}"
                        class="w-full" />
                    @endforeach
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="space-y-2">
                    <x-label value="Libellé" />
                    <x-input type="text" name="label" class="w-full" />
                    <x-label value="Date" />
                    <x-input type="date" name="created_at" class="w-full" />
                    <x-label value="Montant" />
                    <x-input type="text" name="amount" class="w-full" />
                    <x-button type="submit">Enregistrer</x-button>
                </div>
            </div>
        </div>
    </form>
    @if ($expenseReport->extraFees->count() > 0)
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-0">
            <div class="overflow-x-auto">
                <table class="table-auto w-1/2">
                    <h2 class="text-xl font-bold mb-5">Frais non forfaitisés</h2>
                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                        <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Type</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Date</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-right">Montant</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-right">Actions</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @foreach($expenseReport->extraFees as $extraFee)
                        <tr>
                            <td class="p-2 whitespace-nowrap">
                                {{ $extraFee->label }}
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                {{ $extraFee->created_at->format('d/m/Y') }}
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-right font-medium text-green-500">{{
                                    $extraFee->amount }} €</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-right font-medium text-red-500">
                                    <form
                                        action="{{ route('expenseReports.extraFees.destroy', [$expenseReport, $extraFee]) }}"
                                        method="post">
                                        @method('delete')
                                        @csrf
                                        <x-button class="bg-red-500 hover:bg-red-800"
                                            onclick="return confirm('êtes-vous certain?')">
                                            Supprimer
                                        </x-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>