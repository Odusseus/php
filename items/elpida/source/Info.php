<?php namespace Items;
 phpinfo();
 $to      = 'testemail@test.org';
 $subject = 'the subject';
 $message = 'hello';
 $headers = 'From: noreply@odusseus.org' . "\r\n" .
    'Reply-To: noreply@odusseus.org' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>