<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class createUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("--- Create User ---");

        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Senha');
        $passwordConfirmation = $this->secret('Confirmação de Senha');

        $validationRules = [
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'name' => ['required'],
        ];

        $validationFields = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ];

        $validator = Validator::make($validationFields, $validationRules);
        if ($validator->fails()) {
            $this->error($validator->messages());
            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        if ($user) {
            $this->info('Usuário cadastrado com sucesso.');
        } else {
            $this->error('Erro ao cadastrar usuário.');
        }
        
        return 0;
    }
}
