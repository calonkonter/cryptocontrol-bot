<?php
// Ilyasa Fathur Rahman
// SGB-Team Reborn
set_time_limit(0);
error_reporting(0);
echo '####################################';
echo "\r\n";
echo '# Copyright : @ilyasa48 | SGB-Team #';
echo "\r\n";
echo '####################################';
echo "\r\n";
echo 'Masukkan Kode Referral : '; 
$code = trim(fgets(STDIN)); 
echo 'Masukkan Jumlah : '; 
$jumlah = trim(fgets(STDIN)); 
$i=1;
while($i <= $jumlah){
echo "\r\n";
echo "[$i] [".date('h:i:s')."] Membuat email...";
echo "\r\n";
ulang_register:

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://froidcode.com/api/cryptocontrol/register.php?referral=$code");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$register = json_decode($result);

if($register->content == "Gagal, Terjadi Kesalahan [1]"){
    echo "[$i] [".date('h:i:s')."] Gagal, Terjadi Kesalahan [1]";
    echo "\r\n";
    exit();
}

$email = $register->content;
echo "[$i] [".date('h:i:s')."] Email : $email";
echo "\r\n";

echo "[$i] [".date('h:i:s')."] Memeriksa email...";
echo "\r\n";
ulang_email:
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://froidcode.com/api/cryptocontrol/get_email.php?email=$email");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$get_email = json_decode($result);


if($get_email->content == "Email belum masuk"){
    echo "[$i] [".date('h:i:s')."] Email belum masuk, memeriksa email ulang...";
    echo "\r\n";
    goto ulang_email;
}

$url = $get_email->content;
echo "[$i] [".date('h:i:s')."] URL : $url";
echo "\r\n";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://froidcode.com/api/cryptocontrol/finish.php?url=$url");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$finish = json_decode($result);

if($finish->result == "1"){
    echo "[$i] [".date('h:i:s')."] ".$finish->content;
    echo "\r\n";
}else if($finish->result == "0"){
    echo "[$i] [".date('h:i:s')."] ".$finish->content;
    echo "\r\n";
}
$i++;
}