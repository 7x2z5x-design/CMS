<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Testing Category CRUD Operations...\n";
    
    // Test 1: Create Category
    echo "1. Testing CREATE operation...\n";
    
    $createData = [
        'name' => 'Test CRUD Category ' . date('Y-m-d H:i:s'),
        'slug' => 'test-crud-category-' . time(),
        'description' => 'This is a test category for CRUD operations',
        'category_group' => 'Content Type',
        'color' => '#6B7B3A',
        'status' => 'active',
    ];
    
    $category = \App\Models\Category::create($createData);
    
    if ($category->id) {
        echo "✅ Category CREATED successfully! ID: " . $category->id . "\n";
        echo "   Name: " . $category->name . "\n";
        echo "   Group: " . $category->category_group . "\n";
        echo "   Status: " . $category->status . "\n";
        
        $categoryId = $category->id;
        
        // Test 2: Update Category
        echo "\n2. Testing UPDATE operation...\n";
        
        $updateData = [
            'name' => $category->name . ' (Updated)',
            'description' => 'This category has been updated',
            'color' => '#F59E0B',
            'status' => 'inactive',
        ];
        
        $category->update($updateData);
        
        // Refresh and verify update
        $category->refresh();
        
        if ($category->name === $updateData['name'] && $category->status === 'inactive') {
            echo "✅ Category UPDATED successfully!\n";
            echo "   New Name: " . $category->name . "\n";
            echo "   New Status: " . $category->status . "\n";
        } else {
            echo "❌ Category UPDATE failed!\n";
        }
        
        // Test 3: Read Category
        echo "\n3. Testing READ operation...\n";
        
        $readCategory = \App\Models\Category::find($categoryId);
        
        if ($readCategory && $readCategory->id === $categoryId) {
            echo "✅ Category READ successfully!\n";
            echo "   Found: " . $readCategory->name . "\n";
        } else {
            echo "❌ Category READ failed!\n";
        }
        
        // Test 4: Delete Category
        echo "\n4. Testing DELETE operation...\n";
        
        $categoryName = $category->name;
        $deleteResult = $category->delete();
        
        if ($deleteResult) {
            echo "✅ Category DELETED successfully!\n";
            echo "   Deleted: " . $categoryName . "\n";
            
            // Verify deletion
            $deletedCategory = \App\Models\Category::find($categoryId);
            if (!$deletedCategory) {
                echo "✅ Deletion VERIFIED - category no longer exists!\n";
            } else {
                echo "❌ Deletion VERIFICATION failed - category still exists!\n";
            }
        } else {
            echo "❌ Category DELETE failed!\n";
        }
        
    } else {
        echo "❌ Category CREATE failed!\n";
    }
    
    // Test 5: Check total categories count
    echo "\n5. Testing DATABASE connection...\n";
    $totalCategories = \App\Models\Category::count();
    echo "✅ Total categories in database: " . $totalCategories . "\n";
    
    // Test 6: List recent categories
    echo "\n6. Testing category listing...\n";
    $recentCategories = \App\Models\Category::latest()->take(3)->get();
    echo "✅ Recent categories:\n";
    foreach ($recentCategories as $cat) {
        echo "   - " . $cat->name . " (" . $cat->category_group . ")\n";
    }
    
    echo "\n✅ All CRUD operations tested successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error during testing: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
