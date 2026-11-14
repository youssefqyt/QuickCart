<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();

        $signature = $request->header('Stripe-Signature');

        $webhookSecret = config('services.stripe.webhook_secret');

        try {

            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret
            );

        } catch (\UnexpectedValueException $e) {

            return response()->json([
                'message' => 'Invalid payload',
            ], 400);

        } catch (SignatureVerificationException $e) {

            return response()->json([
                'message' => 'Invalid signature',
            ], 400);
        }

        switch ($event->type) {

            case 'checkout.session.completed':

                $session = $event->data->object;

                $orderId = $session->metadata->order_id ?? null;

                if ($orderId) {

                    $order = Order::find($orderId);

                    if ($order) {

                        $order->update([
                            'payment_status' => 'paid',
                            'status' => 'processing',
                            'stripe_session_id' => $session->id,
                            'stripe_payment_intent_id' =>
                                $session->payment_intent,
                        ]);
                    }
                }

                break;


            case 'checkout.session.expired':

                $session = $event->data->object;

                $orderId = $session->metadata->order_id ?? null;

                if ($orderId) {

                    $order = Order::find($orderId);

                    if ($order) {

                        $order->update([
                            'payment_status' => 'failed',
                        ]);
                    }
                }

                break;
        }

        return response()->json([
            'received' => true,
        ]);
    }
}