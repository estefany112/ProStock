<?php

namespace App\Http\Controllers;

use App\Models\PettyCash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PettyCashController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermission('caja.view')) {
            abort(403);
        }

         $cash = PettyCash::where('status', 'open')->first();
        return view('caja.index', compact('cash'));
    }

    public function open(Request $request)
    {
        if (!auth()->user()->hasPermission('caja.open')) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        // No permitir dos cajas abiertas
        if (PettyCash::where('is_open', true)->exists()) {
            return back()->with('error', 'Ya existe una caja abierta');
        }

        $start = Carbon::now()->startOfWeek();
        $end   = Carbon::now()->endOfWeek();

        PettyCash::create([
            'initial_balance' => $request->amount,
            'current_balance' => $request->amount,
            'opened_by'       => auth()->id(),
            'status'          => 'open',
            'period_start'    => $start,
            'period_end'      => $end,
        ]);

        return redirect()->route('caja.index')
            ->with('success', 'Caja semanal abierta correctamente');
    }

    public function storeMovement(Request $request)
    {
        if (!auth()->user()->hasPermission('caja.move')) {
            abort(403);
        }

        $request->validate([
            'movement_category' => 'required|in:income,expense,advance',
            'amount' => 'required|numeric|min:1',
            'concept' => 'required|string|max:255',
            'responsible' => $request->movement_category !== 'income'
                ? 'required|string|max:255'
                : 'nullable',
        ]);

        $cash = PettyCash::where('status', 'open')->firstOrFail();

        // Crear movimiento
        $movement = $cash->movements()->create([
            'type' => $request->movement_category === 'income' ? 'income' : 'expense',
            'movement_category' => $request->movement_category,
            'amount' => $request->amount,
            'concept' => $request->concept,
            'responsible' => $request->responsible,
            'status' => $request->movement_category === 'advance' ? 'pending' : null,
            'user_id' => auth()->id(),
        ]);

        // Recalcular saldo SIEMPRE
        $cash->recalculateBalance();

        return back()->with('success', 'Movimiento registrado correctamente');
    }

    public function close()
    {
        if (!auth()->user()->hasPermission('caja.close')) {
            abort(403);
        }

        $cash = PettyCash::where('status', 'open')->firstOrFail();

        $cash->update([
            'status'   => 'closed',
            'closed_at' => now(),
        ]);

        return redirect()->route('caja.index')
            ->with('success', 'Caja semanal cerrada correctamente');
    }

    public function history()
    {
        if (!auth()->user()->hasPermission('caja.report')) {
            abort(403);
        }

        $cajas = PettyCash::where('is_open', false)
            ->orderByDesc('period_start')
            ->paginate(10);

        return view('caja.history', compact('cajas'));
    }
}
