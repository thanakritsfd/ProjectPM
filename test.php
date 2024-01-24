<?php
header('Content-Type: text/html');

$command = escapeshellcmd('"Python/python.exe" model/predict_pm.py');
$output = shell_exec($command);
echo $output; 
?>
