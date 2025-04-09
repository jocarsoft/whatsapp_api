
<?php
$phone = $_POST['phone'] ?? '';
$message = $_POST['message'] ?? '';

if ($phone && $message) {
    $nodeurl = 'https://apiws.jocarsf.com/send';
    $token = 'TU_TOKEN_AQUI'; // Reemplaza con tu token

    $data = [
        'receiver'  => $phone,
        'msgtext'   => $message,
        'token'     => $token,
        // 'mediaurl' => 'https://whatsapp.jocarsf.com/app-assets/images/logo/logo.png' // opcional
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_URL, $nodeurl);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    if ($json && isset($json['success']) && $json['success']) {
        echo json_encode([
            'status' => 'ok',
            'response' => $json['message']['msgtext'] ?? 'Mensaje enviado correctamente.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'response' => $json['message']['msgtext'] ?? 'Error al enviar el mensaje.'
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos']);
}
?>
