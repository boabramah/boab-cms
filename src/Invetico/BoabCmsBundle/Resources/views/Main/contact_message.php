<?php


$message = '<html><body>';
$message .= '<table rules="all" style="border:1px solid #666;" cellpadding="10">';
$message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . $this->fullName . "</td></tr>";
$message .= "<tr><td><strong>Email:</strong> </td><td>" . $this->email . "</td></tr>";
$message .= "<tr><td><strong>Message:</strong> </td><td>" . $this->message . "</td></tr>";
$message .= "</table>";
$message .= "</body></html>";

echo $message;