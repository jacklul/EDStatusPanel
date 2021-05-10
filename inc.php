<?php

define('JOURNAL_PATH', 'C:/Users/%USERNAME%/Saved Games/Frontier Developments/Elite Dangerous');

$config = [
    'JOURNAL_PATH' => null,
    'REFRESH'      => 1,
];

if (file_exists('config.ini')) {
    $user_config = parse_ini_file('config.ini');
    $config      = array_replace_recursive($config, $user_config);

    if (isset($config['JOURNAL_PATH']) && $config['JOURNAL_PATH'] < 1) {
        $config['JOURNAL_PATH'] = 1;
    }

    if (isset($config['JOURNAL_PATH'])) {
        $GLOBALS["ed_journal_folder"] = $config['JOURNAL_PATH'];
        return;
    }
}

if (empty($username = $_COOKIE["EDSP_WINDOWS_USERNAME"])) {
    exec('echo %USERNAME%', $output, $return);

    if ($return === 0 && count($output) === 1) {
        $username = trim($output[0]);
        setcookie("EDSP_WINDOWS_USERNAME", trim($username));

        if (!is_dir($path = str_replace('%USERNAME%', $username, JOURNAL_PATH))) {
            echo 'Unable to locate journal location! (looked in "' . $path . '")<br>' . PHP_EOL;
            echo 'Copy "config.ini.example" into new file and call it "config.ini" then set your journal path there.';
            exit;
        }
    }
}

$GLOBALS["ed_journal_folder"] = str_replace('%USERNAME%', $username, JOURNAL_PATH);
