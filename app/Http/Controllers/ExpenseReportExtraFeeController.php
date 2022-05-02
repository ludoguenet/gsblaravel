<?php

namespace App\Http\Controllers;

use App\Models\ExtraFee;
use Illuminate\Http\Request;
use App\Models\ExpenseReport;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreExpenseReportRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExpenseReportExtraFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExpenseReport $expenseReport)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ExpenseReport $expenseReport)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseReportRequest $request, ExpenseReport $expenseReport)
    {
        $expenseReport->fees->map(
            fn ($fee) => $fee->update(
                ['quantity' => $request->fees[$fee->type->id]]
            )
        );

        // Si le label, la date et le montant des frais hors forfaits ont été renseignés, nous enregistrons ce frais.
        if ($request->filled(['label', 'created_at', 'amount'])) {
            $extraFee = $expenseReport->extraFees()->create($request->only('label', 'created_at', 'amount'));

            if ($request->has('proof')) {
                $path = $request->file('proof')->store('extra_fee_proofs');
                $extraFee->proof()->create([
                    'filename' => $path
                ]);
            }
        }

        return to_route('report.create')->with('success', 'Les frais ont bien été mis à jour.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseReport $expenseReport, ExtraFee $extraFee): StreamedResponse
    {
        return Storage::download($extraFee->proof->filename);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseReport $expenseReport, ExtraFee $extraFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseReport $expenseReport, ExtraFee $extraFee): JsonResponse
    {
        $request->validate([
            'proofAjaxInput' => 'file|mimes:pdf,png,jpg|max:2048'
        ]);

        $path = $request->file('proofAjaxInput')->store('extra_fee_proofs');
        $extraFee->proof()->create([
            'filename' => $path
        ]);

        return response()->json([
            'success' => 'Justificatif des Frais Hors Forfaits mis à jour.',
            'path' => $path,
            'download_route' => route('expenseReports.extraFees.show', [$expenseReport, $extraFee])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseReport $expenseReport, ExtraFee $extraFee)
    {
        $extraFee->delete();

        return redirect()->back()->with('success', 'Le frais hors forfait a bien été supprimé.');
    }
}
