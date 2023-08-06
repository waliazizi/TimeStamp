<html>
<head>
    <!--    <meta http-equiv="Refresh" content="2">-->
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<br>


<div class="tab">
    <button class="tablinks" onclick="openCity(event, 'originalTab')">Verification with Original file</button>
</div>
<div id="originalTab" class="tabcontent" >

        <h1>VERIFY:</h1>
        <h2>Verification with original data:</h2> <br><br>
        <form method="POST" enctype="multipart/form-data" action="index.php">
            Select the Original file:
            <input type="file" name="original_file">
            Select the ".TSR" file:
            <input type="file" name="tsr_file"><br><br><br><br><br><br>

            <label> Encryption algorithm used during registration: (The default is SHA512 ) </label>

            <select name="digest">
                <option value="sha512">SHA512</option>
                <option value="sha256">SHA256</option>
                <option value="sha1">SHA1</option>
            </select>
            <input class="button" type="submit" name="verify_original" value="Verify Now!">
        </form>
</div>

<div class="gradient">
    <?php



    if(isset($_POST['verify_original']))
    {
        $errorMassage = '';

        if ($_FILES['original_file']['tmp_name'] == '')
            echo $errorMassage = 'Did you choose the original file?';

        else if ($_FILES['tsr_file']['tmp_name'] == '')
            echo $errorMassage = 'Did you select ".tsr" file for the original file?';

        else {

            $algorithm = $_POST['digest'];
            $orig_file = hash_file($algorithm, $_FILES['original_file']['tmp_name']);
            $tsr_for_orig = file_get_contents($_FILES['tsr_file']['tmp_name']);
            $result = $tsa->Verify_with_original_file($orig_file, $tsr_for_orig);
            $user = $tsa->user_details($orig_file);

            if($result[0] === 'Verification: OK')
            { ?><div class="verification_result_ok"><?php
                echo $result[0];
            }else
                {
                    ?><div class="verification_result_failed"><?php
                    echo 'Verification Failed!';
                }
            ?>
            </div>
            <div>
                <?php
                echo 'Registered by: ';     echo $user['name'];echo '<br>';
                echo 'Email: ';             echo $user['email'];echo '<br>';
                echo 'Address: ';           echo $user['address'];echo '<br>';
                if($result[0] === 'Verification: OK'){
                $newarray = array_slice($result, 1, -1);
                foreach ($newarray as $key) {
                    echo $key;
                    echo '<br>';
                };


                ?>

            </div>
    <?php
    }


        }

    }
    ?>

</div>
