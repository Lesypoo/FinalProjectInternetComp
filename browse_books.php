<?php
include('database.php');

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchQuery = "%{$search}%";

$sql = "SELECT * FROM book_database WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ? OR course LIKE ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $searchQuery, $searchQuery, $searchQuery, $searchQuery);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>campuscart | browse</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cinzel', serif;
            background-color: #fdf6ec;
            text-transform: lowercase;
            margin: 0;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 32px;
        }

        form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        input[type="text"] {
            padding: 6px;
            font-family: 'Cinzel', serif;
        }

        button {
            font-family: 'Cinzel', serif;
            background-color: #000;
            color: #fff;
            border: none;
            padding: 8px 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: lowercase;
        }

        button:hover {
            background-color: #333;
            transform: scale(1.05);
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 40px;
            padding-top: 20px;
        }

        .book-card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: zoomIn 0.5s ease forwards;
            transform: scale(0.95);
        }

        .book-card:hover {
            transform: scale(1.03);
            box-shadow: 0 16px 30px rgba(0,0,0,0.08);
        }

        .book-card img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .book-card img:hover {
            transform: scale(1.04);
        }

        .book-card-content {
            padding: 20px;
            text-align: center;
        }

        .book-card h3 {
            font-size: 16px;
            margin-bottom: 6px;
        }

        .book-card p {
            font-size: 14px;
            color: #444;
            margin-bottom: 12px;
        }

        .book-card form {
            display: flex;
            justify-content: center;
        }

        .book-card button {
            font-size: 14px;
            padding: 6px 12px;
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>search results</h1>
    <form action="browse_books.php" method="get">
        <input type="text" name="search" placeholder="search again..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">search</button>
    </form>
</div>

<div class="book-grid">
    <?php while ($book = mysqli_fetch_assoc($result)) { 
        $titleKey = strtolower($book['title']);
        $imagePath = isset($imageMap[$titleKey]) ? $imageMap[$titleKey] : "default.jpg";
    ?>
        <div class="book-card">
            <img src="<?php echo $imagePath; ?>" alt="cover of <?php echo htmlspecialchars($book['title']); ?>">
            <div class="book-card-content">
                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                <p>by <?php echo htmlspecialchars($book['author']); ?></p>
                <form action="cart.php" method="post">
                    <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                    <button type="submit">add to cart</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

</body>
</html>