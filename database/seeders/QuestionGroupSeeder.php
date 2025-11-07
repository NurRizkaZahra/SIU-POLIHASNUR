<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionGroup;

class QuestionGroupSeeder extends Seeder
{
    public function run(): void
    {
        QuestionGroup::create([
            'name' => 'Pengetahuan Umum',
            'is_psikotest' => false,
            'video_tutorial' => null
        ]);
    }
}
