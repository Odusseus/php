<?php namespace Elpida;
 phpinfo();
 $to      = 'pascalboittin@live.nl';
 $subject = 'the subject';
 $message = 'hello';
 $headers = 'From: noreply@odusseus.org' . "\r\n" .
    'Reply-To: noreply@odusseus.org' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>