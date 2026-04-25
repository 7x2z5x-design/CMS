<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create root categories
        $technology = Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Articles about technology, programming, and digital innovation.',
            'color' => '#3B82F6',
            'status' => 'active',
        ]);

        $business = Category::create([
            'name' => 'Business',
            'slug' => 'business',
            'description' => 'Business insights, entrepreneurship, and market analysis.',
            'color' => '#10B981',
            'status' => 'active',
        ]);

        $lifestyle = Category::create([
            'name' => 'Lifestyle',
            'slug' => 'lifestyle',
            'description' => 'Living well, health, and personal development.',
            'color' => '#F59E0B',
            'status' => 'active',
        ]);

        $education = Category::create([
            'name' => 'Education',
            'slug' => 'education',
            'description' => 'Learning resources, tutorials, and educational content.',
            'color' => '#8B5CF6',
            'status' => 'active',
        ]);

        // Create sub-categories
        Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'HTML, CSS, JavaScript, and modern web frameworks.',
            'parent_id' => $technology->id,
            'color' => '#06B6D4',
            'status' => 'active',
        ]);

        Category::create([
            'name' => 'Mobile Apps',
            'slug' => 'mobile-apps',
            'description' => 'iOS and Android app development.',
            'parent_id' => $technology->id,
            'color' => '#EC4899',
            'status' => 'active',
        ]);

        Category::create([
            'name' => 'Startups',
            'slug' => 'startups',
            'description' => 'Startup stories, funding, and growth strategies.',
            'parent_id' => $business->id,
            'color' => '#F97316',
            'status' => 'active',
        ]);

        Category::create([
            'name' => 'Marketing',
            'slug' => 'marketing',
            'description' => 'Digital marketing, SEO, and brand building.',
            'parent_id' => $business->id,
            'color' => '#84CC16',
            'status' => 'active',
        ]);

        // Create an inactive category
        Category::create([
            'name' => 'Archived Content',
            'slug' => 'archived-content',
            'description' => 'Old and archived content.',
            'color' => '#6B7280',
            'status' => 'inactive',
        ]);
    }
}
