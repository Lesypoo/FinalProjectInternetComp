<?php
include('database.php');

// Fetch 3 random books
$sql = "SELECT * FROM book_database ORDER BY RAND() LIMIT 3";
$result = mysqli_query($conn, $sql);

// Image map: lowercase title => image filename
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
    "son" => "son.jpg",
    "divergent" => "divergent.jpg",
    "insurgent" => "insurgent.jpg",
    "allegiant" => "allegiant.jpg",
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>campuscart | home</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cinzel', serif;
            background-color: #fdf6ec;
            text-transform: lowercase;
            margin: 0;
            padding: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .top-bar a {
            color: #000;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .top-bar a:hover {
            color: #555;
            text-decoration: underline;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 32px;
            margin: 0;
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
            text-transform: lowercase;
            background-color: #000;
            color: #fff;
            border: none;
            padding: 8px 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #333;
            transform: scale(1.05);
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin-top: 40px;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 30px;
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
            height: 660px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .book-card img:hover {
            transform: scale(1.04);
        }

        .book-card-content {
            padding: 15px;
            text-align: center;
        }

        .book-card h3 {
            font-size: 18px;
            margin: 10px 0 5px;
        }

        .book-card p {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .book-card form {
            margin-top: 10px;
            display: flex;
            justify-content: center;
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

    <!-- Top Right Links -->
    <div class="top-bar">
        <a href="cart.php">cart</a>
        <a href="login.php">login</a>
        <a href="register.php">register</a>
    </div>

    <!-- Header and Search -->
    <div class="header">
        <h1>campuscart</h1>
        <form action="browse_books.php" method="get">
            <input type="text" name="search" placeholder="search for books...">
            <button type="submit">search</button>
        </form>
    </div>

    <!-- Book Grid -->
    <h2 class="section-title">popular books of the day:</h2>
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