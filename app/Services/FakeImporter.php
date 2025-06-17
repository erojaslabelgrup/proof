<?php

namespace App\Services;

class FakeImporter
{
    public static function users(int $page): array
    {
        $total_pages = 10;

        if ($page < 1 || $page > $total_pages) {
            throw new \InvalidArgumentException("Page must be between 1 and $total_pages.");
        }

        $users = [];

        for($i = 0; $i < 1000; $i++) {
           $users[] = [
               'name' => fake()->firstName() . ' ' . fake()->lastName(),
               'email' => fake()->unique()->safeEmail(),
               'password' => fake()->password(8, 16),
               'import' => fake()->boolean
           ];
        }

        return [
            'users' => $users,
            'total_pages' => $total_pages
        ];
    }
}
