<?php
// database/seed_products.php
require_once __DIR__ . '/../config/db.php';

try {
    // Check if products table already has data
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        echo "Seeding products...\n";

        $products = [
            [
                'category_id' => 3, // Areca Leaf Plates
                'name' => 'Areca Leaf Square Plate',
                'slug' => 'areca-leaf-square-plate',
                'description' => 'Premium quality 100% biodegradable square plates made from naturally fallen Areca Palm leaves. Sturdy, leak-proof, and microwavable. Perfect for eco-friendly catering, weddings, and parties.',
                'sizes' => '8 inch, 10 inch',
                'material' => 'Areca Leaf',
                'moq' => 1000,
                'image' => 'areca_square.png',
                'is_featured' => 1
            ],
            [
                'category_id' => 3, // Areca Leaf Plates
                'name' => 'Areca Leaf Round Plate',
                'slug' => 'areca-leaf-round-plate',
                'description' => 'Elegant round leaf plates crafted from naturally shed Areca Palm leaves. Chemical-free, compostable, and heat resistant. Suitable for serving both hot and cold items.',
                'sizes' => '10 inch, 12 inch',
                'material' => 'Areca Leaf',
                'moq' => 1000,
                'image' => 'areca_round.png',
                'is_featured' => 1
            ],
            [
                'category_id' => 1, // Dona
                'name' => 'Earthy Sal Leaf Dona',
                'slug' => 'earthy-sal-leaf-dona',
                'description' => 'Traditional Indian leaf bowls (Dona) made from dried Sal leaves stitched together with bamboo splints. Highly durable and compostable, ideal for serving street food, desserts, and snacks.',
                'sizes' => '5 inch, 6 inch',
                'material' => 'Sal Leaf',
                'moq' => 5000,
                'image' => 'dona_sal.png',
                'is_featured' => 1
            ],
            [
                'category_id' => 4, // Bowls
                'name' => 'Areca Leaf Dessert Bowl',
                'slug' => 'areca-leaf-dessert-bowl',
                'description' => 'Charming and robust organic dessert bowls. Ideal for ice creams, soups, puddings, and side dishes. Free of chemicals, dyes, or wax.',
                'sizes' => '4 inch, 5 inch',
                'material' => 'Areca Leaf',
                'moq' => 2000,
                'image' => 'areca_bowl.png',
                'is_featured' => 0
            ],
            [
                'category_id' => 5, // Compartment Plates
                'name' => 'Areca 3-Compartment Plate',
                'slug' => 'areca-3-compartment-plate',
                'description' => 'Practical three-compartment plates made from Areca palm leaves. Prevents food mixing, making it the perfect choice for buffets, corporate events, and lunch gatherings.',
                'sizes' => '11 inch, 12 inch',
                'material' => 'Areca Leaf',
                'moq' => 1000,
                'image' => 'areca_3comp.png',
                'is_featured' => 1
            ],
            [
                'category_id' => 6, // Disposable Glasses
                'name' => 'Eco-Friendly Paper Glass',
                'slug' => 'eco-friendly-paper-glass',
                'description' => 'Food-grade disposable paper glasses with bio-lining. Strong rim, leak-proof, and biodegradable. Best suited for water, juices, and hot beverages.',
                'sizes' => '200 ml, 250 ml, 300 ml',
                'material' => 'Biodegradable Paper',
                'moq' => 5000,
                'image' => 'paper_glass.png',
                'is_featured' => 0
            ]
        ];

        $stmtInsert = $pdo->prepare("INSERT INTO products (category_id, name, slug, description, sizes, material, moq, image, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($products as $p) {
            $stmtInsert->execute([
                $p['category_id'],
                $p['name'],
                $p['slug'],
                $p['description'],
                $p['sizes'],
                $p['material'],
                $p['moq'],
                $p['image'],
                $p['is_featured']
            ]);
        }
        echo "Products seeded successfully!\n";
    }

    // Seed Gallery
    $stmtGalleryCount = $pdo->query("SELECT COUNT(*) FROM gallery");
    $galleryCount = $stmtGalleryCount->fetchColumn();

    if ($galleryCount == 0) {
        echo "Seeding gallery...\n";
        $gallery = [
            ['image' => 'g1.png', 'caption' => 'Leaf sorting and washing process', 'type' => 'process'],
            ['image' => 'g2.png', 'caption' => 'High temperature hydraulic pressing machine', 'type' => 'factory'],
            ['image' => 'g3.png', 'caption' => 'Strict quality inspection of finished plates', 'type' => 'process'],
            ['image' => 'g4.png', 'caption' => 'Secure B2B bulk packing and shrink wrapping', 'type' => 'factory'],
            ['image' => 'g5.png', 'caption' => 'Showcase of finished eco tableware collection', 'type' => 'product'],
            ['image' => 'g6.png', 'caption' => 'Ready-for-delivery bulk pallet loading', 'type' => 'factory']
        ];

        $stmtGallery = $pdo->prepare("INSERT INTO gallery (image, caption, type) VALUES (?, ?, ?)");
        foreach ($gallery as $g) {
            $stmtGallery->execute([$g['image'], $g['caption'], $g['type']]);
        }
        echo "Gallery seeded successfully!\n";
    }

} catch (PDOException $e) {
    die("Seeding failed: " . $e->getMessage() . "\n");
}
?>
