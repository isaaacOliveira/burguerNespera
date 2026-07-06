<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // 1. Exibir o Dashboard com Hambúrgueres, Clientes e Pedidos
    public function dashboard()
    {
        // Mantém a listagem dos hambúrgueres mais recentes
        $burgers = Burger::latest()->get();
        
        // Carrega todos os utilizadores que não são administradores para a gestão de clientes
        $users = User::where('role', '!=', 'admin')->orderBy('name', 'asc')->get();
        
        // Carrega todos os pedidos com os dados do cliente e do hambúrguer associado
        $orders = Order::with(['user', 'burger'])->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact('burgers', 'users', 'orders'));
    }

    // 2. Guardar um Novo Hambúrguer (Com upload de Imagem)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('burgers', 'public');
        }

        Burger::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('with_success', 'Hambúrguer adicionado com sucesso!');
    }

    // 3. Remover um Hambúrguer (E apagar o ficheiro de imagem do disco)
    public function destroy(Burger $burger)
    {
        if ($burger->image) {
            Storage::disk('public')->delete($burger->image);
        }
        $burger->delete();
        return redirect()->back()->with('with_success', 'Hambúrguer removido!');
    }

    // 4. Editar/Salvar dados de um Cliente (Via Modal)
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));
        return redirect()->back()->with('success', 'Dados do cliente atualizados com sucesso!');
    }

    // 5. Eliminar/Banir um Cliente do Sistema
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Cliente removido do sistema.');
    }

    // 6. Atualizar o Estado do Pedido (Mudar de Pendente para Entregue)
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string'
        ]);
        
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Estado do pedido atualizado!');
    }
}
