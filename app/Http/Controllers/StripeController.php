<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Reservation;

class StripeController extends Controller
{
    public function checkout(Reservation $reservation)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Acompte Réservation - ' . $reservation->restaurant->nom,
                    ],
                    'unit_amount' => (int) ($reservation->amount * 100) ,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success', $reservation->id),
            'cancel_url' => url('/paiement/'.$reservation->id),
        ]);

        return redirect($session->url);
    }

    public function success(Reservation $reservation)
    {
        $reservation->update([
            'payment_status' => 'paid'
        ]);

     return redirect()->route('facture.show', $reservation->id)
        ->with('success', 'Paiement réussi');

    }
}
