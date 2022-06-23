<?php

if (isset($_GET['kode'])) {
	$sql_cek = "SELECT * FROM tb_pegawai WHERE nip='" . $_GET['kode'] . "'";
	$query_cek = mysqli_query($koneksi, $sql_cek);
	$data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);

	$sql_cek_gaji = "SELECT * FROM tb_gaji WHERE nip='" . $_GET['kode'] . "'";
	// $query_cek_gaji = mysqli_query($koneksi, $sql_cek_gaji);
	$query_cek_gaji = mysqli_query($koneksi, $sql_cek_gaji) or die(mysqli_error($koneksi));
	$data_cek_gaji = mysqli_fetch_array($query_cek_gaji, MYSQLI_BOTH);
}
?>

<div class="card card-success">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-edit"></i> Ubah Data
		</h3>
	</div>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="card-body">

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">NIP</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="nip" name="nip" value="<?php echo $data_cek['nip']; ?>" readonly />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Nama Pegawai</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data_cek['nama']; ?>" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Alamat</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $data_cek['alamat']; ?>" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">No HP</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $data_cek['no_hp']; ?>" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Status</label>
				<div class="col-sm-4">
					<select name="status" id="status" class="form-control">
						<option value="">-- Pilih --</option>
						<?php
						//cek data yg dipilih sebelumnya
						if ($data_cek['status'] == "Pegawai") echo "<option value='Pegawai' selected>Pegawai</option>";
						else echo "<option value='Pegawai'>Pegawai</option>";

						if ($data_cek['status'] == "Honorer") echo "<option value='Honorer' selected>Honorer</option>";
						else echo "<option value='Honorer'>Honorer</option>";
						?>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Jabatan</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $data_cek['jabatan']; ?>" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Gaji</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="gaji" name="gaji" value="<?php echo $data_cek_gaji['jumlah_gaji']; ?>" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Foto Pegawai</label>
				<div class="col-sm-6">
					<img src="foto/<?php echo $data_cek['foto']; ?>" width="160px" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Ubah Foto</label>
				<div class="col-sm-6">
					<input type="file" id="foto" name="foto">
					<p class="help-block">
						<font color="red">"Format file Jpg/Png"</font>
					</p>
				</div>
			</div>
		</div>

		<div class="card-footer">
			<input type="submit" name="Ubah" value="Simpan" class="btn btn-success">
			<a href="?page=data-pegawai" title="Kembali" class="btn btn-secondary">Batal</a>
		</div>
	</form>
</div>

<?php
$sumber = @$_FILES['foto']['tmp_name'];
$target = 'foto/';
$nama_file = @$_FILES['foto']['name'];
$pindah = move_uploaded_file($sumber, $target . $nama_file);


if (isset($_POST['Ubah'])) {

	if (!empty($sumber)) {
		$foto = $data_cek['foto'];
		if (file_exists("foto/$foto")) {
			unlink("foto/$foto");
		}

		$sql_ubah = "UPDATE tb_pegawai SET
			nama='" . $_POST['nama'] . "',
			alamat='" . $_POST['alamat'] . "',
			no_hp='" . $_POST['no_hp'] . "',
			status='" . $_POST['status'] . "',
			jabatan='" . $_POST['jabatan'] . "',
			foto='" . $nama_file . "'		
            WHERE nip='" . $_POST['nip'] . "'";
		$query_ubah = mysqli_query($koneksi, $sql_ubah);

		$sql_ubah_gaji = "UPDATE `tb_gaji` SET `id_gaji`='',`jabatan`='" . $_POST['jabatan'] . "',`gaji`='" . $_POST['gaji'] . "' WHERE NIP='" . $_POST['nip'] . "'";
		$query_ubah_gaji - mysqli_query($koneksi, $sql_ubah_gaji);
	} elseif (empty($sumber)) {
		$sql_ubah = "UPDATE tb_pegawai SET
		nama='" . $_POST['nama'] . "',
		alamat='" . $_POST['alamat'] . "',
		no_hp='" . $_POST['no_hp'] . "',
		status='" . $_POST['status'] . "',
		jabatan='" . $_POST['jabatan'] . "'		
		WHERE nip='" . $_POST['nip'] . "'";
		$query_ubah = mysqli_query($koneksi, $sql_ubah);
		$sql_ubah_gaji = "UPDATE `tb_gaji` SET `id_gaji`='',`jabatan`='" . $_POST['jabatan'] . "',`gaji`='" . $_POST['gaji'] . "' WHERE NIP='" . $_POST['nip'] . "'";
		$query_ubah_gaji - mysqli_query($koneksi, $sql_ubah_gaji);
	}

	if ($query_ubah) {
		echo "<script>
        Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data-pegawai';
            }
        })</script>";
	} else {
		echo "<script>
        Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data-pegawai';
            }
        })</script>";
	}
}
