$id = (int)$_GET['c'];
$row = $conn->query("SELECT * FROM barcodes WHERE id=$id")->fetch_assoc();