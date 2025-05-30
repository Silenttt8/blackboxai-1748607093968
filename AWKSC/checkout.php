<?php
	include 'header.php';
	include 'koneksi.php';
	session_start();

	$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
	$products = [];

	if (empty($cart)) {
		echo "<div class='container'><h3>Keranjang belanja Anda kosong.</h3></div>";
		include 'footer.php';
		exit;
	}

	$ids = implode(',', array_map('intval', array_keys($cart)));
	$query = "SELECT * FROM produk WHERE produk_id IN ($ids)";
	$result = mysqli_query($koneksi, $query);
	while ($row = mysqli_fetch_assoc($result)) {
		$products[$row['produk_id']] = $row;
	}

	$total = 0;
	foreach ($cart as $id => $qty) {
		$total += $products[$id]['harga'] * $qty;
	}

	// Handle order submission (simplified)
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
		// Here you would insert order and payment data into the database
		// For now, just clear the cart and show a success message
		unset($_SESSION['cart']);
		$order_success = true;
	}
?>
<div class="container">
	<h2 class="text-center" style="margin: 20px 0;">Checkout</h2>
	<?php if (isset($order_success) && $order_success) { ?>
		<div class="alert alert-success">
			Pesanan Anda telah berhasil diproses. Terima kasih telah berbelanja!
		</div>
		<a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
	<?php } else { ?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Produk</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cart as $id => $qty) {
					$product = $products[$id];
					$subtotal = $product['harga'] * $qty;
				?>
				<tr>
					<td><?php echo htmlspecialchars($product['nama_produk']); ?></td>
					<td>Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></td>
					<td><?php echo $qty; ?></td>
					<td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="3" class="text-right"><strong>Total</strong></td>
					<td><strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></td>
				</tr>
			</tbody>
		</table>
		<form method="post" action="">
			<button type="submit" name="place_order" class="btn btn-success">Konfirmasi Pesanan</button>
		</form>
	<?php } ?>
</div>
<?php include 'footer.php'; ?>
