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
            [
                'id' => 3,
                'title' => 'Страница удалена'
            ],
            [
                'id' => 4,
                'title' => 'Страница восстановлена'
            ],
        ];

        foreach($rows as $row) {
            DiffType::firstOrCreate($row);
        }
    }
}
