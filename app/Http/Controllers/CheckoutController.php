<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Store;
use App\Payment\PagSeguro\CreditCard;
use App\Payment\PagSeguro\Notification;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CheckoutController extends Controller
{
    public function index()
    {
        //session()->forget('pagseguro_session_id');

        if (!session()->has('cart')) {
            return redirect()->route('cart.index');
        }

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->makePagSeguroSession();

        $total = array_map(function ($line) {
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));

        $total = array_sum($total);

        return view('checkout', compact('total'));
    }

    public function proccess(Request $request)
    {
        try {
            $cart = session()->get('cart');
            $storeIds = array_unique(array_column($cart, 'store_id'));
            $user = auth()->user();
            $data = $request->all();
            $reference = Uuid::uuid4();

            $creditCardPayment = new CreditCard($cart, $user, $data, $reference);
            $result = $creditCardPayment->doPayment();

            $order = [
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cart),
            ];

            $order = $user->orders()->create($order);
            $order->stores()->sync($storeIds);

            $store = (new Store())->notifyStoreOwners($storeIds, $order);

            session()->forget('cart');
            session()->forget('pagseguro_session_code');

            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Pedido criado.',
                    'orderReference' => $reference
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar o pagamento.';

            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => $message
                ]
            ], 401);
        }
    }

    public function thanks()
    {
        return view('thanks');
    }
    public function notification()
    {
        try {
            $notification = new Notification();
            $transaction = $notification->getTransaction();
            $reference = base64_decode($transaction->getReference());
            $order = Order::whereReference($reference);
            $order->update([
                'pagseguro_status' => $transaction->getStatus()
            ]);

            if ($transaction->getStatus() == 3) { // Se pago
                // Colocar pedido "Em separação"
                // Confirmar pagamento para o usuário
                // Confirmar pedido para a loja
            }

            return response()->json([], 204);
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : [];
            return response()->json(['error' => $message], 500);
        }
    }

    private function makePagSeguroSession()
    {
        if (!session()->has('pagseguro_session_id')) {

            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            session()->put('pagseguro_session_id', $sessionCode->getResult());
        }
    }
}
