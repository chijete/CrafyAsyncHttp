<?php

// Credits:
// Crafy Holding - https://chijete.com/
// https://dev.to/jackmarchant/exploring-async-php-5b68
// https://humblecontributions.blogspot.com/2012/12/how-to-run-php-process-in-background.html

#[AllowDynamicProperties]
class CrafyAsyncHttp {
  function __construct(
    $temp_files_path // Absolute path to folder for temporal files.
  ) {
    $this->temp_files_path = $temp_files_path;
    return true;
  }

  public function makeAsyncCurl(
    $url, // Equivalent to curl_setopt($ch, CURLOPT_URL, {this})
    $custom_options = null, // Equivalent to curl_setopt($ch, {$custom_options->key}, {$custom_options->value})
    $time_limit = 0 // Temporal PHP file execution time limit (0 is unlimited).
  ) {
    $data = [
      "url" => $url,
      "custom_options" => $custom_options,
    ];
    $data = base64_encode(json_encode($data));
    $new_file_path = $this->temp_files_path . '/tmpcurl_' . time() . '_' . uniqid() . '_' . random_int(100000000,999999999) . '.php';
    $new_file_content = '
    <?php
      set_time_limit('.$time_limit.');
      $data = "'.$data.'";
      $data = json_decode(base64_decode($data), true);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $data["url"]);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      if (!is_null($data["custom_options"]) AND !empty($data["custom_options"])) {
        foreach ($data["custom_options"] as $optionName => $optionValue) {
          curl_setopt($ch, constant($optionName), $optionValue);
        }
      }
      $result = curl_exec($ch);
      curl_close($ch);
      unlink(__FILE__);
    ?>
    ';
    $new_file_creation = file_put_contents($new_file_path, $new_file_content);
    if ($new_file_creation !== false) {
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { // Windows OS
        // https://humblecontributions.blogspot.com/2012/12/how-to-run-php-process-in-background.html
        // - hating windows but with love :)
        $command = 'start /B php "'.$new_file_path.'" > NUL';
        pclose( popen( $command, 'r' ) );
        $execution = true;
      } else { // Unix OS
        // https://dev.to/jackmarchant/exploring-async-php-5b68
        $command = 'php "'.$new_file_path.'" > /dev/null &';
        $execution = exec($command);
      }
      if ($execution !== false) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
}

?>