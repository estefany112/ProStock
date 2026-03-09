<?php

namespace App\Mail;

use App\Models\PettyCash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailable;

class PettyCashReportMail extends Mailable
{
    public function build()
    {
        $cash = PettyCash::where('status','open')->first();

        $movements = $cash->movements()->get();

        $pdf = Pdf::loadView('reports.petty_cash_report', [
            'cash' => $cash,
            'movements' => $movements
        ]);

        return $this->subject('Reporte Caja Chica PROSERVE')
            ->view('emails.report')
            ->attachData($pdf->output(), 'reporte_caja_chica.pdf');
    }
}