<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Bienvenue sur votre compte GSB!
                </div>
                <form action="{{ route('report.index') }}" method="get" class="p-6">
                    <label for="expense-report-month">Choisir le mois</label>

                    <select name="expenseReportMonth" id="expense-report-month">
                        <option value="">--Quel mois--</option>
                        @foreach ($expenseReportMonths as $expenseReportMonth)
                        <option value="{{ $expenseReportMonth }}">{{ $expenseReportMonth->translatedFormat('M Y') }}
                        </option>
                        @endforeach
                    </select>
                    <x-button type="submit">Chercher</x-button>
                </form>

                @isset ($expenseReport)
                <!-- component -->
                <section class="antialiased bg-gray-100 text-gray-600">
                    <div class="flex flex-col justify-center h-full">
                        <!-- Table -->
                        <div class="w-full mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                            <header class="py-4 border-b border-gray-100 p-6">
                                <h2 class="font-semibold text-gray-800">{{
                                    $expenseReport->created_at->translatedFormat('F Y') }}</h2>
                            </header>
                            <div class="p-3">
                                <div class="overflow-x-auto">
                                    <table class="table-auto w-1/2">
                                        <h2 class="text-xl p-3">Frais Forfaitisés</h2>
                                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                            <tr>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-left">Type</div>
                                                </th>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-left">Quantité</div>
                                                </th>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-right">Total</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm divide-y divide-gray-100">
                                            @foreach($expenseReport->fees as $fee)
                                            <tr>
                                                <td class="p-2 whitespace-nowrap">
                                                    {{ $fee->type->label }}
                                                </td>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-left font-medium text-green-500">{{ $fee->quantity
                                                        }}</div>
                                                </td>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-right font-medium text-green-500">{{
                                                        $fee->getTotal()
                                                        }} €</div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($expenseReport->extraFees->count() > 0)
                            <div class="p-3">
                                <div class="overflow-x-auto">
                                    <table class="table-auto w-1/2">
                                        <h2 class="text-xl p-3">Frais Non Forfaitisés</h2>
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
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>
                @endisset
            </div>
        </div>
    </div>
</x-app-layout>