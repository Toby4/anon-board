<?php 
include("inc/header.php");
include("inc/config.php");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
$path = $_FILES["image"]["tmp_name"];
$name = $_FILES["image"]["name"];

$errors = array(1 => 'php.ini max file size exceeded', 
                2 => 'html form max file size exceeded', 
                3 => 'file upload was only partial', 
                4 => 'no file was attached');

$error = false;

/* Checks for image erros etc.. */

if(!isset($_POST["submit"])) {
	echo "<h3>Error: The form expired.</h3>";
	$error = true;
}

if(getimagesize($path) == false) {
	echo "<h3>Error: The uploaded file was not an image.</h3>";
	$error = true;
}

if (!isset($_FILES["image"]["error"]) || is_array($_FILES["image"]["error"])) {
    echo "<h3>File Upload Corruption.<h3>";
    $error = true;
}

if ($_FILES["image"]["size"] > 1000000) {
	echo "<h3>Image too large.</h3>";
    $error = true;
}

$image = file_get_contents($path);
$type = pathinfo($name, PATHINFO_EXTENSION);

/* Uploads to imgur */

$url = "https://api.imgur.com/3/image.json";
$headers = array("Authorization: Client-ID " . $client_id);
$pvars = array('image' => base64_encode($image));

$curl = curl_init();

curl_setopt_array($curl, array(
   CURLOPT_URL=> $url,
   CURLOPT_TIMEOUT => 30,
   CURLOPT_POST => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_HTTPHEADER => $headers,
   CURLOPT_POSTFIELDS => $pvars
));

$json = curl_exec($curl);
$data = json_decode($json, true);
curl_close($curl);

$data = $data["data"]; /* imgur y u do dis */

/* Check for upload errors */

if(isset($data["link"])) {
	echo "<img src='".$data["link"]."' />";
} else {
	echo "<h3>Error: Imgur image upload failed</h3>";
}
 
include("inc/footer.php");