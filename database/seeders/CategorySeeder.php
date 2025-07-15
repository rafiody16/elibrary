<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name_category' => 'Fiksi', 'description' => 'Buku cerita dan novel fiksi'],
            ['name_category' => 'Non-Fiksi', 'description' => 'Buku ilmiah dan dokumenter'],
            ['name_category' => 'Teknologi', 'description' => 'Buku tentang komputer dan teknologi'],
            ['name_category' => 'Sastra', 'description' => 'Karya sastra dan puisi'],
            ['name_category' => 'Biografi', 'description' => 'Kisah hidup tokoh terkenal'],
            ['name_category' => 'Pendidikan', 'description' => 'Buku pelajaran dan edukasi'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name_category' => $category['name_category'],
                'description'   => $category['description'],
            ]);
        }
    }
}
