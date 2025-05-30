<?php
	include 'header.php';
	include 'koneksi.php';

	if (!isset($_GET['id'])) {
		echo "<div class='container'><h3>Produk tidak ditemukan.</h3></div>";
		include 'footer.php';
		exit;
	}

	$id = intval($_GET['id']);
	$query = "SELECT * FROM produk WHERE produk_id = $id";
	$result = mysqli_query($koneksi, $query);

	if (mysqli_num_rows($result) == 0) {
		echo "<div class='container'><h3>Produk tidak ditemukan.</h3></div>";
		include 'footer.php';
		exit;
	}

	$product = mysqli_fetch_assoc($result);

	// Handle add to cart
	session_start();
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
		$qty = intval($_POST['quantity']);
		if ($qty < 1) $qty = 1;

		if (!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = [];
		}

		if (isset($_SESSION['cart'][$id])) {
			$_SESSION['cart'][$id] += $qty;
		} else {
			$_SESSION['cart'][$id] = $qty;
		}

		header("Location: cart.php");
		exit;
	}
?>
<div class="container">
	<h2 class="text-center" style="margin: 20px 0;"><?php echo htmlspecialchars($product['nama_produk']); ?></h2>
	<div class="row">
		<div class="col-md-6">
			<?php if($product['gambar']) { ?>
				<img src="gambar/<?php echo htmlspecialchars($product['gambar']); ?>" alt="<?php echo htmlspecialchars($product['nama_produk']); ?>" class="img-responsive" style="max-height: 400px; object-fit: cover;">
			<?php } else { ?>
				<img src="https://via.placeholder.com/400" alt="No Image" class="img-responsive" style="max-height: 400px; object-fit: cover;">
			<?php } ?>
		</div>
		<div class="col-md-6">
			<p><?php echo nl2br(htmlspecialchars($product['deskripsi'])); ?></p>
			<p><strong>Harga: Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></strong></p>
			<form method="post" action="">
				<div class="form-group">
					<label for="quantity">Jumlah:</label>
					<input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" style="width: 100px;">
				</div>
				<button type="submit" name="add_to_cart" class="btn btn-success">Tambah ke Keranjang</button>
			</form>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>
