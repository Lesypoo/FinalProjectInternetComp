<?php
require 'database.php';
include 'header.php';

// Ensure admin-only access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    echo "<p>Access denied. Admins only.</p>";
    include 'footer.php';
    exit;
}

// Approve a listing
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $stmt = $pdo->prepare("UPDATE books SET approved = 1 WHERE id = ?");
    $stmt->execute([$id]);
}

// Delete a book
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$id]);
}

// Get all books
$stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
$books = $stmt->fetchAll();
?>

<h1>Admin Panel</h1>

<table border="1" cellpadding="8">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Condition</th>
        <th>Price</th>
        <th>Approved</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($books as $book): ?>
    <tr>
        <td><?= htmlspecialchars($book['title']) ?></td>
        <td><?= htmlspecialchars($book['author']) ?></td>
        <td><?= htmlspecialchars($book['book_condition']) ?></td>
        <td>$<?= number_format($book['price'], 2) ?></td>
        <td><?= $book['approved'] ? 'Yes' : 'No' ?></td>
        <td>
            <?php if (!$book['approved']): ?>
                <a href="?approve=<?= $book['id'] ?>">Approve</a>
            <?php endif; ?>
            <a href="?delete=<?= $book['id'] ?>" onclick="return confirm('Delete this listing?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
