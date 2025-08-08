<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Validate data
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle validation errors (e.g., redirect back to form with an error message)
        http_response_code(400);
        echo "Please fill out the form completely and with a valid email address.";
        exit;
    }

    // Set the recipient email address
    $recipient = "your_email@example.com"; // *** REPLACE WITH YOUR EMAIL ADDRESS ***

    // Set the email subject
    if (empty($subject)) {
        $email_subject = "New message from ICON RIG LTD website";
    } else {
        $email_subject = "ICON RIG LTD Contact Form: $subject";
    }


    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Email sent successfully
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
        // Optional: Redirect to a thank you page
        // header("Location: thank_you.html");
    } else {
        // Email failed to send
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    // Not a POST request, set a 403 (Forbidden) response code
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>