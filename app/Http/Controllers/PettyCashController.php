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

        $cash = PettyCash::where('is_open', true)->first();
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
            'initial_amount'  => $request->amount,
            'current_balance' => $request->amount,
            'opened_by'       => auth()->id(),
            'is_open'         => true,
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
            'type'    => 'required|in:income,expense',
            'amount'  => 'required|numeric|min:1',
            'concept' => 'required|string|max:255'
        ]);

        $cash = PettyCash::where('is_open', true)->firstOrFail();

        if (!$cash->is_open) {
            abort(403, 'La caja de esta semana ya está cerrada');
        }

        $cash->movements()->create([
            'type'    => $request->type,
            'amount'  => $request->amount,
            'concept' => $request->concept,
            'user_id' => auth()->id(),
        ]);

        $cash->current_balance +=
            $request->type === 'income'
                ? $request->amount
                : -$request->amount;

        $cash->save();

        return back();
    }

    public function close()
    {
        if (!auth()->user()->hasPermission('caja.close')) {
            abort(403);
        }

        $cash = PettyCash::where('is_open', true)->firstOrFail();

        $cash->update([
            'is_open'   => false,
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
