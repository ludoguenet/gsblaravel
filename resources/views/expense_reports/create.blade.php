<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Saisir fiche frais') }}
        </h2>
    </x-slot>

    @if(session()->has('errors'))
        <x-alert :message="session('errors')->first()" type="error" />
    @endif

    @if(session()->has('success'))
        <x-alert :message="session('success')" type="success" />
    @endif

    <form action="{{ route('expenseReports.extraFees.store', $expenseReport) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-xl font-bold mb-5">Frais forfaitisés</h1>
                <div class="space-y-2">
                    @foreach ($expenseReport->fees as $fee)
                    <x-label value="{{ $fee->type->label }}" />
                    <x-input type="text" name="fees[{{ $fee->type->id }}]" value="{{ $fee->quantity }}"
                        class="w-1/5" />
                    @endforeach
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-xl font-bold mb-5">Frais Hors Forfaits</h1>
                <div class="space-y-2">
                    <x-label value="Libellé" />
                    <x-input type="text" name="label" class="w-1/5" value="{{ old('label') }}" placeholder="Gourde isotherme" />
                    <x-label value="Date" />
                    <x-input type="date" name="created_at" class="w-1/5" value="{{ old('created_at') }}" />
                    <x-label value="Montant" />
                    <x-input type="text" name="amount" class="w-1/5" value="{{ old('amount') }}" placeholder="19,99" />
                    <div class="flex w-full py-5">
                        <label
                            class="w-64 flex flex-col items-center px-4 py-6 bg-gray-100 text-blue rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:bg-gray-300 hover:text-gray-600">
                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                            </svg>
                            <span class="mt-2 text-base leading-normal">Envoyer un justificatif</span>
                            <input type="file" name="proof" class="hidden" />
                        </label>
                    </div>
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
                    <h2 class="text-xl font-bold mb-5">Frais Hors Forfaits</h2>
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
                                <div class="text-right font-medium text-green-500">
                                    {{ $extraFee->amount }} €
                                </div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-right font-medium text-red-500">
                                    <div class="flex items-center justify-end">
                                        @if ($extraFee->proof()->exists())
                                        <a
                                            href="{{ route('expenseReports.extraFees.show', [$expenseReport, $extraFee]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                        @else
                                        <form action="{{ route('expenseReports.extraFees.update', [$expenseReport, $extraFee]) }}" method="post" id="proofAjaxForm-{{ $extraFee->id }}" enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="flex w-full py-5">
                                                <label
                                                    class="cursor-pointer hover:text-gray-400 text-gray-900">
                                                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                    </svg>
                                                    <input type="file"
                                                    name="proofAjaxInput"
                                                    class="hidden proofAjaxClass"
                                                    id="{{ $extraFee->id }}" />
                                                </label>
                                            </div>
                                        </form>
                                        @endif
                                    <form
                                        action="{{ route('expenseReports.extraFees.destroy', [$expenseReport, $extraFee]) }}"
                                        method="post">
                                        @method('delete')
                                        @csrf

                                            <x-button class="bg-red-500 hover:bg-red-800 ml-5"
                                                onclick="return confirm('êtes-vous certain?')">
                                                Supprimer
                                            </x-button>
                                        </div>
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