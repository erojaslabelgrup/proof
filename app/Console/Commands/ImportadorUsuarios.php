<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\FakeImporter;
use Illuminate\Console\Command;

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
                    User::create([$user_data]);
                }
            } catch (\Throwable $th) {
                break; // Break the loop if an error occurs
            }
        }

        $this->info('Import users completed successfully.');

        return self::SUCCESS;
    }
}
