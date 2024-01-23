<?php
header('Content-Type: text/html');

$command = escapeshellcmd('"Python/python.exe" model/predict_pm.py');
$output = shell_exec($command);

// if ($output === null) {
//     // Handle error if shell_exec fails
//     echo "Error executing command: $command";
//     // Display error from the shell command
//     echo "<pre>" . shell_exec('echo') . "</pre>";
// } else {
//     // Display the output directly
//     echo $output;
// }
?>
