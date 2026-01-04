<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cuci Biasa',
                'slug' => 'cuci-biasa',
                'description' => 'Layanan cuci reguler dengan durasi standar',
                'icon' => 'washing-machine',
                'color' => '#3B82F6',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Cuci Kering',
                'slug' => 'cuci-kering',
                'description' => 'Layanan cuci dan kering tanpa setrika',
                'icon' => 'droplet',
                'color' => '#06B6D4',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Cuci Setrika',
                'slug' => 'cuci-setrika',
                'description' => 'Layanan lengkap: cuci, kering, dan setrika',
                'icon' => 'steam',
                'color' => '#10B981',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Dry Cleaning',
                'slug' => 'dry-cleaning',
                'description' => 'Layanan dry cleaning untuk pakaian khusus',
                'icon' => 'sparkles',
                'color' => '#8B5CF6',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Setrika',
                'slug' => 'setrika',
                'description' => 'Hanya setrika untuk pakaian yang sudah dicuci',
                'icon' => 'fire',
                'color' => '#F59E0B',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Karpet & Gordin',
                'slug' => 'karpet-gordin',
                'description' => 'Layanan khusus untuk karpet dan gordin',
                'icon' => 'grid-3x3',
                'color' => '#EF4444',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }

        $this->command->info('Service categories seeded successfully!');
    }
}

