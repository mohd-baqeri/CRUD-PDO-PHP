<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "test_db";

// Set DSN (Data Source Name)
$dsn = "mysql:host=$host; dbname=$database";

// Create PDO Obj
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// test variables
$title = 'Post Title One';

# PDO Query
$stmt = $pdo->query("SELECT * FROM tbl");
/*
    stmt->fetch()
        PDO::FETCH_ASSOC
        PDO::FETCH_OBJ
    Set Attribute
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
*/

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row["title"] . "<br>";
}

// --------------------------------------

# Prepared Statement (prepare & execute)

// Unsafe
$query = "SELECT * FROM tbl WHERE title='$title'";

// Positional Params
$query = "SELECT * FROM tbl WHERE title=?";
$stmt = $pdo->prepare($query);
$stmt->execute([$title]);
$posts = $stmt->fetchAll();

foreach ($posts as $post) {
    echo $post->title . "<br>";
}

// Named Params
$query = "SELECT * FROM tbl WHERE title=:title";
$stmt = $pdo->prepare($query);
$stmt->execute(["title" => $title]);
$posts = $stmt->fetchAll();

foreach ($posts as $post) {
    echo $post->title . "<br>";
}

$query = "SELECT * FROM tbl WHERE title=:title";
$stmt = $pdo->prepare($query);
$stmt->execute(["title" => $title]);
$posts = $stmt->fetch();
echo $posts->body;

// Get row count
$query = "SELECT * FROM tbl WHERE title=:title";
$stmt = $pdo->prepare($query);
$stmt->execute(["title"=>$title]);
$rowCount = $stmt->rowCount();
echo $rowCount;

// Insert Data
$title = "Test Post";
$body = "Test Body";
$query = "INSERT INTO tbl(title, body) VALUES(:title, :body)";
$stmt = $pdo->prepare($query);
$stmt->execute(["title"=>$title, "body"=>$body]);
echo "Added";

// Update Data
$id = 3;
$title = "Post Title";
$body = "Post's Body";
$query = "UPDATE tbl SET title=:title, body=:body WHERE id=:id";
$stmt = $pdo->prepare($query);
$stmt->execute(["title"=>$title, "body"=>$body, "id"=>$id]);
echo "Post Updated";

// Delete Data
$id = 4;
$query = "DELETE FROM tbl WHERE id=:id";
$stmt = $pdo->prepare($query);
$stmt->execute(["id"=>$id]);
echo "Deleted";

?>