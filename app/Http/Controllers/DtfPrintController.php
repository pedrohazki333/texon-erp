<?php

namespace App\Http\Controllers;

use App\Models\DtfPrint;
use Illuminate\Http\Request;

class DtfPrintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dtfPrints = DtfPrint::all();
        return view('dtfprints.index', compact('dtfPrints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = ['pendente', 'em produção', 'impresso', 'finalizado'];
        return view('dtfprints.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'print_date' => 'required|date',
            'meters' => 'required|numeric|min:0.1',
            'status' => 'required|in:pendente,em produção,impresso,finalizado',
        ]);

        DtfPrint::create($request->only('print_date', 'meters', 'status'));

        return redirect()->route('dtfprints.index')->with('success', 'Impressão registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dtfPrint = DtfPrint::findOrFail($id);
        $statuses = ['pendente', 'em produção', 'impresso', 'finalizado'];
        return view('dtfprints.edit', compact('dtfPrint', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dtfPrint = DtfPrint::findOrFail($id);

        $request->validate([
            'print_date' => 'required|date',
            'meters' => 'required|numeric|min:0.1',
            'status' => 'required|in:pendente,em produção,impresso,finalizado',
        ]);

        $dtfPrint->update([
            'print_date' => $request->print_date,
            'meters' => $request->meters,
            'status' => $request->status
        ]);

        return redirect()->route('dtfprints.index')->with('success', 'Impressão atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dtfPrint = DtfPrint::findOrFail($id);
        $dtfPrint->delete();
        return redirect()->route('dtfprints.index')->with('success', 'Impressão excluída com sucesso!');
    }
}
