<?php

$urlv = 'https://raw.githubusercontent.com/darknessm427/V2rayCollector/main/vmess_iran.txt';
$filePath = 'sub/vmess';

$content = file_get_contents($url);

if ($content !== false) {

    $content = preg_replace('/@.*/', '', $content);

    function changeNameInVmessLink($vmessLink) {
        $jsonPart = base64_decode(substr($vmessLink, strpos($vmessLink, '://') + 3));
        $data = json_decode($jsonPart, true);

        if ($datavmess !== null && isset($datavmess['ps'])) {
            $newName = implode(' | ', array_slice(explode(' | ', $data['ps']), 0, 2)) . ' |𓄂𓆃';
            $data['ps'] = $newName;
            $newJsonPart = base64_encode(json_encode($data));

            return substr_replace($vmessLink, $newJsonPart, strpos($vmessLink, '://') + 3);
        }

        return $vmessLink;
    }

    $contentLines = explode(PHP_EOL, $content);
    foreach ($contentLines as &$line) {
        if (strpos($line, 'vmess://') === 0) {
            $line = changeNameInVmessLink($line);
        }
    }
    unset($line);

    $headerSections = [
        '#profile-title: base64:Vm1lc3PjgJjirLPwk4SC8JOGg+Kfv+OAmVZtZXNz',
        '#profile-update-interval: 1',
        '#subscription-userinfo: upload=0; download=0; total=10737418240000000; expire=2546249531',
        '#profile-web-page-url: https://github.com/darknessm427'
    ];

    $content = implode(PHP_EOL, $headerSections) . PHP_EOL . implode(PHP_EOL, $contentLines);

    $writeResult = file_put_contents($filePath, $content);

    if ($writeResult !== false) {
        echo 'Content successfully fetched and specified sections replaced. Content saved in ' . $filePath . '.';
    } else {
        echo 'Error saving content to the file.';
    }
} else {
    echo 'Error fetching content from the link.';
}
?>
