<?php

if(isset($_GET['kode'])){
    $sql_cek = "select * from tb_pegawai where nip='".$_GET['kode']."'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek,MYSQLI_BOTH);

    $sql_cek_gaji = "select * from tb_gaji where nip='".$_GET['kode']."'";
    $query_cek_gaji = mysqli_query($koneksi, $sql_cek_gaji);
    $data_cek_gaji = mysqli_fetch_array($query_cek_gaji,MYSQLI_BOTH);
}
?>

<?php
    $foto= $data_cek['foto'];
    if (file_exists("foto/$foto")){
        unlink("foto/$foto");
    }

    $sql_hapus = "DELETE FROM tb_pegawai WHERE nip='".$_GET['kode']."'";
    $query_hapus = mysqli_query($koneksi, $sql_hapus);

    $sql_hapus_gaji = "DELETE FROM tb_gaji WHERE NIP='".$_GET['kode']."'";
    mysqli_query($koneksi, $sql_hapus_gaji);

    if ($query_hapus) {
        echo "<script>
        Swal.fire({title: 'Hapus Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value) {window.location = 'index.php?page=data-pegawai'
        ;}})</script>";
        }else{
        echo "<script>
        Swal.fire({title: 'Hapus Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value) {window.location = 'index.php?page=data-pegawai'
        ;}})</script>";
    }
