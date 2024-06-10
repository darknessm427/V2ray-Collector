<?php

$urlvmess = 'https://raw.githubusercontent.com/darknessm427/V2rayCollector/main/vmess_iran.txt';
$filePathvmess = 'sub/vmess';


$contentvmess = file_get_contents($urlvmess);

if ($contentvmess !== false) {

    $contentvmess = preg_replace('/@.*/', '', $contentvmess);

    function changeNameInVmessLink($vmessLink) {
        $jsonPartvmess = base64_decode(substr($vmessLink, strpos($vmessLink, '://') + 3));
        $datavmess = json_decode($jsonPartvmess, true);

        if ($datavmess !== null && isset($datavmess['ps'])) {
            $newNamevmess = implode(' | ', array_slice(explode(' | ', $datavmess['ps']), 0, 2)) . ' |𓄂𓆃';
            $datavmess['ps'] = $newNamevmess;
            $newJsonPartvmess = base64_encode(json_encode($datavmess));

            return substr_replace($vmessLink, $newJsonPartvmess, strpos($vmessLink, '://') + 3);
        }

        return $vmessLink;
    }

    $contentLinesvmess = explode(PHP_EOL, $contentvmess);
    foreach ($contentLinesvmess as &$linevmess) {
        if (strpos($line, 'vmess://') === 0) {
            $linevmess = changeNameInVmessLink($linevmess);
        }
    }
    unset($linevmess);

    $headerSectionsvmess = [
        '#profile-title: base64:Vm1lc3PjgJjirLPwk4SC8JOGg+Kfv+OAmVZtZXNz',
        '#profile-update-interval: 1',
        '#subscription-userinfo: upload=0; download=0; total=10737418240000000; expire=2546249531',
        '#profile-web-page-url: https://github.com/darknessm427'
    ];

    $contentvmess = implode(PHP_EOL, $headerSectionsvmess) . PHP_EOL . implode(PHP_EOL, $contentLines);

    $writeResult = file_put_contents($filePath, $content);

    if ($writeResult !== false) {
        echo 'Content successfully fetched and specified sections replaced. Content saved in ' . $filePathvmess . '.';
    } else {
        echo 'Error saving content to the file.';
    }
} else {
    echo 'Error fetching content from the link.';
}

?>
