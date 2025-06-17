<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\FakeImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ImportadorUsuarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importador:usuarios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importador de usuarios desde un archivo CSV';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        for ($page = 0; $page < 100000; $page++) {
            try {
                $data = FakeImporter::users($page); // return param users and total_pages

                foreach ($data['users'] as $user_data) {
                    User::create([
                        'name' => $user_data['name'],
                        'email' => $user_data['email'],
                        'password' => Hash::make($user_data['password']),
                        'is_admin' => $user_data['is_admin'],
                    ]);
                }
            } catch (\Throwable $th) {
                break; // Break the loop if an error occurs
            }
        }

        $this->info('Import users completed successfully.');

        return self::SUCCESS;
    }
}
