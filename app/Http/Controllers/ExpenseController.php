<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('expense.index', [
            'title' => 'Pengeluaran (Expenses)',
            'expenses' => Expense::with('property')->latest('expense_date')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expense.create', [
            'title' => 'Tambah Pengeluaran',
            'properties' => Property::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ], [
            'property_id.required' => 'Properti wajib dipilih',
            'property_id.exists' => 'Properti tidak ditemukan',
            'description.required' => 'Deskripsi pengeluaran wajib diisi',
            'amount.required' => 'Nominal pengeluaran wajib diisi',
            'amount.numeric' => 'Nominal pengeluaran harus berupa angka',
            'amount.min' => 'Nominal pengeluaran tidak boleh kurang dari 0',
            'expense_date.required' => 'Tanggal pengeluaran wajib diisi',
            'expense_date.date' => 'Format tanggal tidak valid',
        ]);

        DB::beginTransaction();

        try {
            Expense::create($validate);

            DB::commit();
            return to_route('expense.index')->withSuccess('Data pengeluaran berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('expense.create')->withError('Gagal menambahkan pengeluaran: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('expense.show', [
            'title' => 'Detail Pengeluaran',
            'expense' => $expense->load('property'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return view('expense.edit', [
            'title' => 'Edit Pengeluaran',
            'expense' => $expense,
            'properties' => Property::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validate = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ], [
            'property_id.required' => 'Properti wajib dipilih',
            'property_id.exists' => 'Properti tidak ditemukan',
            'description.required' => 'Deskripsi pengeluaran wajib diisi',
            'amount.required' => 'Nominal pengeluaran wajib diisi',
            'amount.numeric' => 'Nominal pengeluaran harus berupa angka',
            'amount.min' => 'Nominal pengeluaran tidak boleh kurang dari 0',
            'expense_date.required' => 'Tanggal pengeluaran wajib diisi',
            'expense_date.date' => 'Format tanggal tidak valid',
        ]);

        DB::beginTransaction();

        try {
            $expense->update($validate);

            DB::commit();
            return to_route('expense.index')->withSuccess('Data pengeluaran berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('expense.edit', $expense)->withError('Gagal mengubah pengeluaran: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        DB::beginTransaction();

        try {
            $expense->delete();

            DB::commit();
            return to_route('expense.index')->withSuccess('Data pengeluaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('expense.index')->withError('Gagal menghapus pengeluaran: ' . $e->getMessage());
        }
    }
}
