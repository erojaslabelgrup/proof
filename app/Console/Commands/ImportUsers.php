<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\FakeImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from a fake data source';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $total_pages = $this->importPage();
            $this->info("Successfully imported users from {$total_pages} pages.");

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error during user import: ' . $e->getMessage());

            return self::FAILURE;
        }
    }

    protected function importPage(int $page = 1): int
    {
        $data = FakeImporter::users($page);
        $users = $data['users'] ?? [];
        $total_pages = $data['total_pages'] ?? 0;

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'is_admin' => $user['is_admin'],
            ]);
        }

        if ($page < $total_pages) {
            $this->importPage($page + 1);
        }

        return $total_pages;
    }
}
