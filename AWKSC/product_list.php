<?php
	include 'header.php';
	include 'koneksi.php';

	// Query products from database
	$query = "SELECT * FROM produk";
	$result = mysqli_query($koneksi, $query);
?>
<div class="container">
	<h2 class="text-center" style="margin: 20px 0;">Daftar Produk</h2>
	<div class="row">
		<?php while($row = mysqli_fetch_assoc($result)) { ?>
			<div class="col-md-4">
				<div class="thumbnail">
					<?php if($row['gambar']) { ?>
						<img src="gambar/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>" style="height: 200px; object-fit: cover;">
					<?php } else { ?>
						<img src="https://via.placeholder.com/200" alt="No Image" style="height: 200px; object-fit: cover;">
					<?php } ?>
					<div class="caption">
						<h4><?php echo htmlspecialchars($row['nama_produk']); ?></h4>
						<p><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
						<p><strong>Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></strong></p>
						<p><a href="product_detail.php?id=<?php echo $row['produk_id']; ?>" class="btn btn-primary" role="button">Detail</a></p>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<?php include 'footer.php'; ?>
