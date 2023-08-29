<?php
$dataFromLSL = $_POST['data'];

$processedData = strtoupper($dataFromLSL);

$lslScript = "your_lsl_script_here";

$url = "http://secondlife.com/lalarukh/lsl_number/?data=" . urlencode($processedData);

$response = file_get_contents($url);

echo $response;
?>
