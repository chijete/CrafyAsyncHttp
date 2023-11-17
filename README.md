# CrafyAsyncHttp
Simple unidirectional Asynchronous CURL PHP library

## Files
- class.php contains the class.
- index.php contains an example.

## Principal class (CrafyAsyncHttp) methods
### __construct
Parameters:
- `$temp_files_path` Absolute path to folder for temporal files (example "/usr/local/crafy_temp_files/")
### makeAsyncCurl
Parameters:
- `$url Equivalent` Equivalent to curl_setopt($ch, CURLOPT_URL, {this}) (HTTP request target URL).
- `$custom_options` Equivalent to curl_setopt($ch, {$custom_options->key}, {$custom_options->value}) (CURL Options as associative array).
- `$time_limit` Temporal PHP file execution time limit (Default 0: unlimited).
