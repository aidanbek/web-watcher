<?php

namespace Database\Seeders;

use App\Models\DiffType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiffTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            [
                'id' => 1,
                'title' => 'Нет изменений'
            ],
            [
                'id' => 2,
                'title' => 'Есть изменения'
            ],
        ];

        foreach($rows as $row) {
            DiffType::firstOrCreate($row);
        }
    }
}
