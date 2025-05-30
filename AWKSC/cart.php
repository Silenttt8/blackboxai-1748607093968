<?php
	include 'header.php';
	include 'koneksi.php';
	session_start();

	// Handle update quantities
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
		foreach ($_POST['quantities'] as $id => $qty) {
			$qty = intval($qty);
			if ($qty < 1) {
				unset($_SESSION['cart'][$id]);
			} else {
				$_SESSION['cart'][$id] = $qty;
			}
		}
		header("Location: cart.php");
		exit;
	}

	$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
	$products = [];

	if (!empty($cart)) {
		$ids = implode(',', array_map('intval', array_keys($cart)));
		$query = "SELECT * FROM produk WHERE produk_id IN ($ids)";
		$result = mysqli_query($koneksi, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$products[$row['produk_id']] = $row;
		}
	}
?>
<div class="container">
	<h2 class="text-center" style="margin: 20px 0;">Keranjang Belanja</h2>
	<?php if (empty($cart)) { ?>
		<p>Keranjang belanja Anda kosong.</p>
	<?php } else { ?>
		<form method="post" action="">
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
					<?php
					$total = 0;
					foreach ($cart as $id => $qty) {
						$product = $products[$id];
						$subtotal = $product['harga'] * $qty;
						$total += $subtotal;
					?>
					<tr>
						<td><?php echo htmlspecialchars($product['nama_produk']); ?></td>
						<td>Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></td>
						<td><input type="number" name="quantities[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="0" class="form-control" style="width: 80px;"></td>
						<td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="3" class="text-right"><strong>Total</strong></td>
						<td><strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></td>
					</tr>
				</tbody>
			</table>
			<div class="text-right">
				<button type="submit" name="update_cart" class="btn btn-primary">Update Keranjang</button>
				<a href="checkout.php" class="btn btn-success">Checkout</a>
			</div>
		</form>
	<?php } ?>
</div>
<?php include 'footer.php'; ?>
