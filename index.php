<?php
session_start();
include('db.php'); // Database connection

// Fetch featured products (fetching 5 latest products)
$sql = "SELECT * FROM products ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

// Check if query execution is successful
if (!$result) {
    die("Error fetching products: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetic Store - Home</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="logo">
            <a href="index.php">Cosmetic Store</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cart.php">Cart</a></li>
                
                <?php if (isset($_SESSION['username'])) { ?>
                    <li><a href="my_orders.php">My Orders</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php } else { ?>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="signup.html">Sign Up</a></li>
                <?php } ?>
                
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="featured-products">
            <h2>Featured Cosmetics</h2>
            <div class="product-list">
                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="product">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                 style="width:200px; height:200px;">
                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <p>₹<?php echo htmlspecialchars($row['price']); ?></p>                            
                            
                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="add-to-cart-btn">🛒 Add to Cart</button>
                            </form>


                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No products available.</p>
                <?php } ?>
            </div>
        </section>

        <section class="categories">
            <h2>Browse Categories</h2>
            <div class="category-list">
                <?php
                $categories = [
                    "skincare" => "skincare.jpg",
                    "makeup" => "makeup.jpg",
                    "haircare" => "haircare.jpg",
                    "perfume" => "perfume.jpg",
                    "nailcare" => "nailcare.jpg"
                ];
                foreach ($categories as $category => $image) {
                    echo '<div class="category">
                            <a href="' . $category . '.php">
                                <img src="assets/' . $image . '" alt="' . ucfirst($category) . '">
                                <p>' . ucfirst($category) . '</p>
                            </a>
                          </div>';
                }
                ?>
            </div>
        </section>

        <section class="promotions">
            <h2>Special Offers</h2>
            <p>Get 20% off on your first beauty purchase! Use code: <strong>BEAUTY20</strong> at checkout.</p>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Cosmetic Store. All rights reserved.</p>
            <ul>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="privacy-policy.html">Privacy Policy</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
