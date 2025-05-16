<?php

while (true) {
        $motion = random_int(0, 1) ? "Motion Detecteddd" : "No Motion";
        $data = json_encode(['motion' => $motion]);

    $ch = curl_init('http://192.168.190.106:8000/api/sensors'); // or use your local IP
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    echo "Sent motion: " . $motion . "\n";
    sleep(5);
}
