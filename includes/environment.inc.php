<?php
$env_file_path = realpath('.env');
$env_file_content = file_get_contents($env_file_path);
$lines = explode("\n", $env_file_content);

foreach($lines as $line) {
    // ignore lines starting with '#' or don't have value after '='
    preg_match("/([^#]+)\=(.*)/", $line, $matches);
    if(isset($matches[2])) {
        putenv(trim($line));
    }
}
?>
