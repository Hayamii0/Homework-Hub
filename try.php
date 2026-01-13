<?php
echo "<h1>Testing MySQL Connection</h1>";

// Test basic PDO connection
try {
    $pdo = new PDO("mysql:host=localhost", "root", "");
    echo "✅ Connected to MySQL server<br>";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE 'homeworkhub_db'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Database 'homeworkhub_db' exists<br>";
        
        // Try connecting to the database
        $pdo2 = new PDO("mysql:host=localhost;dbname=homeworkhub_db", "root", "");
        echo "✅ Connected to 'homeworkhub_db' database<br>";
        
        // Check tables
        $tables = $pdo2->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        if (count($tables) > 0) {
            echo "✅ Tables found: " . implode(", ", $tables) . "<br>";
        } else {
            echo "⚠️ No tables found in database<br>";
        }
    } else {
        echo "❌ Database 'homeworkhub_db' does NOT exist<br>";
        echo "Run: CREATE DATABASE homeworkhub_db;<br>";
    }
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Check if MySQL is running in XAMPP<br>";
}
?>