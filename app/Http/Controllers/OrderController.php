<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Ver o Dashboard do cliente com os seus pedidos
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                       ->with('burger')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('customer.dashboard', compact('orders'));
    }

    // 2. Criar um novo pedido
    public function store(Request $request, Burger $burger)
    {
        Order::create([
            'user_id' => auth()->id(),
            'burger_id' => $burger->id,
            'quantity' => 1,
            'total_price' => $burger->price,
            'status' => 'pendente'
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Pedido realizado com sucesso! 🍔');
    }

    // 3. Cancelar o pedido (Apenas se estiver pendente)
    public function cancel(Order $order)
    {
        // Segurança: Garante que o pedido pertence ao utilizador logado
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status === 'pendente') {
            $order->update(['status' => 'cancelado']);
            return redirect()->back()->with('success', 'Pedido cancelado.');
        }

        return redirect()->back()->with('error', 'Este pedido já está em preparação e não pode ser cancelado.');
    }
}
