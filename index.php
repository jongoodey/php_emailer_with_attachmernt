<?php
    
    function mail_file($to, $from, $subject, $body, $file){
       $boundary = md5(rand());
       
       $headers = array(
        'MIME-Version: 1.0',
        "Content-Type: multipart/mixed; boundary=\"{$boundary}\"",
        "From: {$from}"
         ); 

       $message = array(
        "--{$boundary}",
        'Content-Type: text/plain',
        'Content-Transfer-Encoding: 7bit',
        '',
        chunk_split($body),
        "--{$boundary}",
        "Content-Type: {$file['type']}; name=\"{$file['name']}\"",
        "Content-Disposition: attachment; filename=\"{$file['name']}\"",
        "Content-Transfer-Encoding: base64",
        '',
        chunk_split(base64_encode(file_get_contents($file['tmp_name']))),
        "--{$boundary}--"
        );

       mail($to, $subject, implode("\r\n", $message), implode("\r\n", $headers));
    }

if (isset($_POST['name'], $_FILES['file'])) {
    
    $body = " From: {$_POST['name']} " . "
    Details:
        Name: {$_FILES['file']['name']}
        Size: {$_FILES['file']['size']}
        Type: {$_FILES['file']['type']} "

    ;

    mail_file('<YOUR REPCIPIENT HERE>', '<YOUR EMAIL HERE>', '<SUBJECT NAME>', $body, $_FILES['file']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>email form</title>
</head>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        <p>
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
        </p>
        <p>
            <label for="file">file</label>
            <input type="file" name="file" id="file">
        </p>
        <p>
            <input type="submit" value="Email File" />
        </p>

    </form>

</body>
</html>