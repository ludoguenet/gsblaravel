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
                    <!-- Chart's container -->
                    <div id="chart" style="height: 300px;"></div>
                    <!-- Charting library -->
                    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
                    <!-- Chartisan -->
                    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
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
                                                    <div class="text-left font-medium">{{ $fee->quantity
                                                        }}</div>
                                                </td>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-right font-medium text-green-500">
                                                        {{ $fee->formatted_total }}
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-right font-semibold w-1/2 mt-3">Total : {{ format_amount($expenseReport->fees_total) }}</div>
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
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-right">Justificatif</div>
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
                                                    <div class="text-right font-medium {{ $extraFee->proof()->exists() ? 'text-green-500' : 'text-orange-500' }}">
                                                        {{ $extraFee->amount }} €
                                                    </div>
                                                </td>
                                                <td class="p-2 whitespace-nowrap flex justify-end">
                                                    @if ($extraFee->proof()->exists())
                                                    <a
                                                        href="{{ route('expenseReports.extraFees.show', [$expenseReport, $extraFee]) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </a>
                                                    @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                      </svg>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-right font-semibold w-1/2 mt-3">Total : {{ format_amount($expenseReport->extra_fees_sum_amount) }}</div>
                                </div>
                                <div class="text-right w-1/2 mt-5 font-bold">Total des totaux : {{ format_amount($expenseReport->totalOfTotals) }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>
                @endisset
            </div>
        </div>
    </div>
    <!-- Your application script -->
    <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('expense_chart')"
        });
        </script>
</x-app-layout>