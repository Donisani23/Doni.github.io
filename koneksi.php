<?php
// Set error reporting dan tampilkan error di layar
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mulai session
session_start();

// Include file konfigurasi dan fungsi
require_once '../sw-library/sw-config.php';
include_once '../sw-library/sw-function.php';

// Buat koneksi ke database
$dbhostsql = DB_HOST;
$dbusersql = DB_USER;
$dbpasswordsql = DB_PASSWD;
$dbnamesql = DB_NAME;
$connection = mysqli_connect($dbhostsql, $dbusersql, $dbpasswordsql, $dbnamesql);

// Periksa koneksi ke database
if (!$connection) {
    die("Koneksi database gagal: " . mysqli_connect_error());
} else {
    echo "Koneksi database berhasil!";
}

// Set variabel-variabel untuk informasi situs
$website_url = $row_site['site_url'];
$website_name = $row_site['site_name'];
$website_phone = $row_site['site_phone'];
$website_addres = $row_site['site_address'];
$meta_description = $row_site['site_description'];
$website_logo = $row_site['site_logo'];
$website_email = $row_site['site_email'];

// Mendapatkan informasi browser pengguna dan host name
$iB = getBrowser();
$browser = $iB['name'];
$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$tgl_active = date('Y-m-d');

// Mendapatkan modul dari URL atau set default ke 'home'
if (!empty($_GET['mod'])) {
    $mod = mysqli_escape_string($connection, @$_GET['mod']);
} else {
    $mod = 'home';
}

// Include header
include_once 'sw-mod/sw-header.php';

// Mulai output buffering
ob_start();

// Cek apakah file modul ada
if (file_exists('./sw-mod/' . $mod . '/' . $mod . '.php')) {
    include('sw-mod/' . $mod . '/' . $mod . '.php');
    include_once 'sw-mod/sw-footer.php';
} else {
    include('sw-mod/home/home.php');
    include_once 'sw-mod/sw-footer.php';
}

// Akhiri output buffering dan tampilkan outputnya
ob_end_flush();
?>
