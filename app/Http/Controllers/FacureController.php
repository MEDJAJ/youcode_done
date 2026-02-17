<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use FPDF;

class FacureController extends Controller
{
    

public function show(Reservation $reservation)
{
    return view('vuesclient.facture', compact('reservation'));
}


  




    public function download(Reservation $reservation)
    {
        $restaurant = $reservation->restaurant;

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(0, 10, 'FACTURE DE RESERVATION', 0, 1, 'C');

        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(0, 10, 'Numero Reservation: #' . $reservation->id, 0, 1);
        $pdf->Cell(0, 10, 'Date: ' . $reservation->date, 0, 1);
        $pdf->Cell(0, 10, 'Heure: ' . $reservation->time, 0, 1);
        $pdf->Cell(0, 10, 'Nombre de personnes: ' . $reservation->guests, 0, 1);
        $pdf->Cell(0, 10, 'Montant total: ' . $reservation->amount . ' EUR', 0, 1);

        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Informations Restaurant', 0, 1);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Nom: ' . $restaurant->nom, 0, 1);
        $pdf->Cell(0, 10, 'Adresse: ' . $restaurant->location, 0, 1);
        $pdf->Cell(0, 10, 'Type de cuisin: ' . $restaurant->type_de_cuisin, 0, 1);

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="facture.pdf"');
    }
}


