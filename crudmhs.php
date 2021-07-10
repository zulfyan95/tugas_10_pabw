<?php
require_once 'koneksiakad.php';

// membaca (select) tabelmahasiswa
// jika berhasil, hasil array dr baris-baris data
// dan setiap baris data berupa array dari nama-nama field
// jika tidak ada, hasil berupa nilai null

// baca mahasiswa
function bacaMhs($sql) {
    $data = array();
    $koneksi = koneksiAkademik();
    $hasil = mysqli_query($koneksi, $sql);

    // jika tidak ada record, hasil berupa null
    if (mysqli_num_rows($hasil) == 0) {
        mysqli_close($koneksi);
        return null;
    }

    $i=0;
    while($baris = mysqli_fetch_assoc($hasil)) {
        $data[$i]['nim']= $baris['nim'];
        $data[$i]['nama'] = $baris['nama'];
        $data[$i]['kelamin'] = $baris['kelamin'];
        $data[$i]['jurusan'] = $baris['jurusan'];
        $i++;
    }

    mysqli_close($koneksi);
    return $data;
}

Function bacaSemuaMhs() {
    $sql ="select * from mahasiswa";
    $data = bacaMhs($sql);

    return $data;
}

Function bacaMhsPerJurusan($jurusan) {
    $sql ="select * from mahasiswa where jurusan='$jurusan'";
    $data = bacaMhs($sql);

    return $data;
}

Function cariMhsDariNim($nim) {
    $sql ="select * from mahasiswa where nim='$nim'";
    $data = bacaMhs($sql);

    return $data;
}


// tambah mahasiswa
function tambahMhs($nim, $nama, $kelamin, $jurusan) {
    $koneksi = koneksiAkademik();
    $sql = "insert into mahasiswa values('$nim', '$nama', '$kelamin', '$jurusan')";
    $hasil = 0;

    if (mysqli_query($koneksi, $sql)) {
        $hasil = 1;
        mysqli_close($koneksi);

        return $hasil;
    }
}

// hapus mahasiswa
function hapusMhs($nim) {
    $koneksi = koneksiAkademik();
    $sql = "delete from mahasiswa where nim = '$nim'";

    if (!mysqli_query($koneksi, $sql)) {
        die('Error:'.mysqli_error($koneksi));
    } else {
        $hasil = mysqli_affected_rows($koneksi);
        mysqli_close($koneksi);
    }

    return $hasil;
}

// mencari data berdasar nim
// jika ada, hasil array dengan indeks berupa nama field
// jika tidak ada hasil berupa nilai null

// cari mahasiswa
function cariMhs($nim) {
    $koneksi = koneksiAkademik();
    $sql = "select * from mahasiswa where nim='$nim'";
    $hasil = mysqli_query($koneksi, $sql);

    if(mysqli_num_rows($hasil)>0) {
        $baris=mysqli_fetch_assoc($hasil);

        $data['nim']=$baris['nim'];
        $data['nama'] = $baris['nama'];
        $data['kelamin'] = $baris['kelamin'];
        $data['jurusan'] = $baris['jurusan'];

        mysqli_close($koneksi);
        return $data;
    } else {
        mysqli_close($koneksi);
        return null;
    }
}


// mencari data berdasar kondisi
// jika ada, hasil array dr baris-baris data
// dan setiap baris data berupa array dari nama-nama field
// jika tidak ada hasil berupa nilai null

// cari semua mahasiswa
function cariSemuaMhs($kondisi){
    $sql = "select * from mahasiswa where $kondisi";
    return bacaMhs($sql);
}

// mengubah (update) record berdasar nim
// data baru berupa nama, kelamin, jurusan
// dimasukkan dalam parameter fungsi

// ubah mahasiswa
function ubahMhs($nim, $nama, $kelamin, $jurusan) {
    $koneksi = koneksiAkademik();

    $sql = "UPDATE mahasiswa
    SET nama = '$nama',
    kelamin = '$kelamin',
    jurusan = '$jurusan'
    WHERE nim = '$nim'";

    if (mysqli_query($koneksi, $sql)) {
        $hasil = true;
    } else {
        $hasil = "Error mengubah record: " . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
    return $hasil;
}