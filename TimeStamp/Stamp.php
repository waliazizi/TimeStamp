<?php

if(isset($_POST['register'])) {
    $name           = trim($_POST['nama']);
    $email_address  = trim($_POST['email_address']);
    $address        = trim($_POST['address']);
    $algorithm      = $_POST['digest'];

    if(!preg_match('/^[a-z ]+$/i', $name))
        $errorMassage[] = 'Please write your name with no special characters!';

    else if (!preg_match ( '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i',$email_address))
        $errorMassage[] = 'Something must be wrong with your email address!';

    else if ($_FILES['browsedFile']['tmp_name'] == '')
        $errorMassage[] = 'Have you selected your file?';

    else if(file_exists($file_hash = hash_file($algorithm, $_FILES['browsedFile']['tmp_name'])))
        $errorMassage[] = 'Hashing algorithm failed!';

    else if($tsa->check_existance($file_hash)== false)
        $errorMassage[] = 'This file is already registered !';



    else{
        $file = tempnam("tmp", "zip");
        $zip = new ZipArchive();
        $zip->open($file, ZipArchive::OVERWRITE);
        $path_to_tsq = $tsa->tsq($file_hash, $algorithm);
        $tsa->hash_to_db($name, $email_address, $address, $file_hash,$path_to_tsq);
        $zip->addFromString('file.tsq', $path_to_tsq);
        $zip->addFromString('file.tsr', $tsa->tsr($path_to_tsq));
        $zip->close();
        ob_clean();
        header('Content-Type: application/zip');
        header('Content-Length: ' . filesize($file));
        header('Content-Disposition: attachment; filename="file.zip"');
        readfile($file);
        unlink($file);
        }
}
?>

<html>
<head>
</head>
<body>
<br>

<div class="tab" id="defaultOpen">
    <button class="tablinks" onclick="openCity(event, 'stampTab')" id="defaultOpen" >Time Stamp</button>
</div>

<div id="stampTab" class=""><br>
    <div class="stamp">
        <div>
            <?php if(isset($errorMassage))
            {
            foreach ($errorMassage as $errorMassage)
            {
            ?> <div class="errorM"> <?php echo $errorMassage; echo '<br>';
                }
                }
                ?>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
             <br>
                <label>Enter details below:</label> <br><br>
            <input type="text" name="nama" placeholder="Name" value="<?php if(isset($errorMassage)){echo $name;}?>"><br>
            <br>
            <input type="text" name="email_address" placeholder="Email address" value="<?php if(isset($errorMassage)){echo $email_address;}?>"><br>
            <input type="text" name="address" placeholder="Home address" value="<?php if(isset($errorMassage)){echo $address;}?>"><br>
                <br><br>
            <input type="file" name="browsedFile">
                <label> Encryption algorithm to use:</label>
                <select name="digest">
                <option value="sha512">SHA512</option>
                <option value="sha256">SHA256</option>
                <option value="sha1">SHA1</option>
                </select>
            <br><br><br><br>
            <input class="button" type="submit" name="register" value="Register now!">

        </form>
            <p>
                Click on "Register now!" and download the tsq and tsr files for your data. it is a good practice to
                keep those files in safe place!.

               <br>
                Your file never leave your browser. The hash value of your file will be taken within your browser.
            </p>
    </div>
</div>


<div class="gradient">
</div>
