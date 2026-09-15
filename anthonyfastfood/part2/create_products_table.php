<?php
require_once 'db.php';

// Create products table
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($connection->query($sql) === TRUE) {
    echo "Products table created successfully<br>";
} else {
    echo "Error creating products table: " . $connection->error . "<br>";
}

// Insert sample products
$sample_products = [
    [
        'Big Burger',
        9.99,
        'Classic beef burger with cheese and fresh vegetables'
    ],
    [
        'Chicken Wings',
        12.99,
        'Crispy chicken wings with choice of sauce'
    ],
    [
        'French Fries',
        4.99,
        'Golden crispy french fries'
    ],
    [
        'Soft Drink',
        2.99,
        'Various soft drinks available'
    ],
    [
        'Stop',
        0.00,
        'Stop command for staff operations'
    ]
];

// Prepare and execute insert statements
$stmt = $connection->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");

foreach ($sample_products as $product) {
    $stmt->bind_param("sds", $product[0], $product[1], $product[2]);
    if ($stmt->execute()) {
        echo "Product added: " . $product[0] . "<br>";
    } else {
        echo "Error adding product " . $product[0] . ": " . $stmt->error . "<br>";
    }
}

$stmt->close();
$connection->close();

echo "<br><a href='index.php'>Return to Home</a>";
?>