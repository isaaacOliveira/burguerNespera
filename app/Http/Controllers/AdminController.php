<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// Corrigidas as maiúsculas dos namespaces da Cloudinary para o SDK puro
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

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

    // 2. Guardar um Novo Hambúrguer (Com upload para o Cloudinary)
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
            // Configura a API com as credenciais que definiste no Render / .env
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => [
                    'secure' => true
                ]
            ]);

            // Obtém o caminho temporário da imagem no servidor local
            $file = $request->file('image')->getRealPath();

            // Faz o upload direto para a nuvem dentro da pasta 'burgers'
            $response = (new UploadApi())->upload($file, [
                'folder' => 'burgers'
            ]);

            // Devolve a URL segura completa gerada pelo Cloudinary
            $imagePath = $response['secure_url'];
        }

        Burger::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath, // Guarda o link completo (ex: https://res.cloudinary.com/...)
        ]);

        return redirect()->back()->with('with_success', 'Hambúrguer adicionado com sucesso!');
    }

    // 3. Remover um Hambúrguer 
    public function destroy(Burger $burger)
    {
        // Nota: Como as imagens agora estão seguras no Cloudinary e o Render reinicia o disco,
        // podes simplesmente apagar o registo. Se quiseres apagar no Cloudinary via API no futuro, avisame!
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
