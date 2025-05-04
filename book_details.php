<?php
include('database.php');

function getBookDetails($bookID) {
    global $conn;
    $sql = "SELECT * FROM book_database WHERE book_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $bookID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

$imageMap = [
    "harry potter and the sorcerer's stone" => "sorcerersstone.jpg",
    "harry potter and the chamber of secrets" => "chamberofsecrets.jpg",
    "harry potter and the prisoner of azkaban" => "prisonerofazkaban.jpg",
    "harry potter and the goblet of fire" => "gobletoffire.jpg",
    "harry potter and the order of the phoenix" => "orderofthephoenix.jpg",
    "harry potter and the half-blood prince" => "halfbloodprince.jpg",
    "harry potter and the deathly hallows" => "deathlyhallows.jpg",
    "the giver" => "thegiver.jpg",
    "messenger" => "messenger.jpg",
    "gathering blue" => "gatheringblue.jpg",
    "divergent" => "divergent.jpg",
    "insurgent" => "insurgent.jpg",
    "allegiant" => "allegiant.jpg",
    "four" => "four.jpg"
];

$bookID = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;
$book = getBookDetails($bookID);
if (!$book) {
    echo "Book not found.";
    exit;
}

$titleKey = strtolower($book['title']);
$imagePath = isset($imageMap[$titleKey]) ? $imageMap[$titleKey] : "default.jpg";
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($book['title']); ?> | Book Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cinzel', serif;
            background-color: #fdf6ec;
            margin: 0;
            padding: 40px;
            text-transform: lowercase;
        }

        .book-detail-container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            background-color: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .book-detail-container img {
            width: 300px;
            height: 450px;
            object-fit: cover;
            border-radius: 12px;
        }

        .book-info {
            flex: 1;
        }

        .book-info h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .book-info p {
            font-size: 16px;
            color: #444;
            margin: 8px 0;
        }

        .book-info form {
            margin-top: 20px;
        }

        .book-info button {
            font-family: 'Cinzel', serif;
            background-color: #000;
            color: #fff;
            border: none;
            padding: 10px 16px;
            cursor: pointer;
            font-size: 16px;
            text-transform: lowercase;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .book-info button:hover {
            background-color: #333;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<a href="browse_books.php" class="back-link">← back to options</a>

<div class="book-detail-container">
    <img src="<?php echo $imagePath; ?>" alt="cover of <?php echo htmlspecialchars($book['title']); ?>">
    <div class="book-info">
        <h1><?php echo htmlspecialchars($book['title']); ?></h1>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
        <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
        <p><strong>Course:</strong> <?php echo htmlspecialchars($book['course']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($book['price']); ?></p>
        <p><strong>Condition:</strong> <?php echo htmlspecialchars($book['condition']); ?></p>
        <form action="cart.php" method="post">
            <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
            <button type="submit">add to cart</button>
        </form>
    </div>
</div>

</body>
</html>
