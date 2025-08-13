<?php

// Simple database test script
require_once 'vendor/autoload.php';

try {
    // Test database connection
    $db = new mysqli('localhost', 'root', '', 'queuebank_promax');
    
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    
    echo "Database connected successfully!\n";
    
    // Check if categories table exists
    $result = $db->query("SHOW TABLES LIKE 'kategori_antrians'");
    if ($result->num_rows > 0) {
        echo "Table kategori_antrians exists!\n";
        
        // Check existing categories
        $result = $db->query("SELECT * FROM kategori_antrians");
        if ($result->num_rows > 0) {
            echo "Existing categories:\n";
            while ($row = $result->fetch_assoc()) {
                echo "- {$row['nama_kategori']} ({$row['prefix']}): {$row['deskripsi']}\n";
            }
        } else {
            echo "No categories found. Inserting default categories...\n";
            
            // Insert default categories
            $categories = [
                ['Teller', 'T', 'Layanan teller untuk transaksi perbankan'],
                ['Customer Service', 'C', 'Layanan customer service untuk informasi dan konsultasi'],
                ['Prioritas', 'P', 'Layanan prioritas untuk nasabah prioritas']
            ];
            
            foreach ($categories as $cat) {
                $sql = "INSERT INTO kategori_antrians (nama_kategori, prefix, deskripsi, status, created_at, updated_at) 
                        VALUES (?, ?, ?, 'aktif', NOW(), NOW())";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("sss", $cat[0], $cat[1], $cat[2]);
                
                if ($stmt->execute()) {
                    echo "Inserted: {$cat[0]}\n";
                } else {
                    echo "Failed to insert {$cat[0]}: " . $stmt->error . "\n";
                }
                $stmt->close();
            }
        }
    } else {
        echo "Table kategori_antrians does not exist!\n";
    }
    
    $db->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
