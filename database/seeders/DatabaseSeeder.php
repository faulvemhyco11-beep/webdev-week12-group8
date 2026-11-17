<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $people = [
            ['Alice', 'alice@example.com'],
            ['Bob', 'bob@example.com'],
        ];

        foreach ($people as [$name, $email]) {
            $user = User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => 'password',
            ]);

            $user->books()->createMany([
                ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'status' => 'finished', 'rating' => 5],
                ['title' => 'Refactoring', 'author' => 'Martin Fowler', 'status' => 'reading', 'rating' => null],
                ['title' => 'The Pragmatic Programmer', 'author' => 'Hunt and Thomas', 'status' => 'to-read', 'rating' => null],
            ]);
        }
    }
}