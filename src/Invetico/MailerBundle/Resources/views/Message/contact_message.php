<?php

$message = '<html><body>';
$message .= '<table rules="all" style="border:1px solid #666;width:100%" cellpadding="10">';
$message .= "<tr><td style='background: #eee;'><strong>Name:</strong> </td><td>" . $this->fullName . "</td></tr>";
$message .= "<tr><td style='background: #eee;'><strong>Email:</strong> </td><td>" . $this->email . "</td></tr>";
$message .= "<tr><td style='background: #eee;'><strong>Contact Number:</strong> </td><td>" . $this->contactNumber. "</td></tr>";
$message .= "<tr><td style='background: #eee;'><strong>Subject:</strong> </td><td>" . $this->subject . "</td></tr>";
$message .= "<tr><td style='background: #eee;'><strong>Message:</strong> </td><td>" . $this->message . "</td></tr>";
$message .= "</table>";
$message .= "</body></html>";

echo $message;