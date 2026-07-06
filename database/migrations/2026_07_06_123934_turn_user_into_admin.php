<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
       
    // Procura o utilizador na nuvem e força a alteração para admin
        $user = User::where('email', 'admin@burguernespera.com')->first();
        
        if ($user) {
            $user->forceFill(['role' => 'admin'])->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $user = User::where('email', 'admin@burguernespera.com')->first();
        if ($user) {
            $user->forceFill(['role' => 'client'])->save();
        }
    }
};
