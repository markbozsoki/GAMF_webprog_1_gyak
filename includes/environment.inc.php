<?php
$env_file_content = file_get_contents(__DIR__.".env");
$lines = explode("\n", $env_file_content);

foreach($lines as $line) {
    // ignore lines starting with '#' or don't have value after '='
    preg_match("/([^#]+)\=(.*)/", $line, $matches);
    if(isset($matches[2])) {
        putenv(trim($line));
    }
}
?>
