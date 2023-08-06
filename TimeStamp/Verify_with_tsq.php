<html>
<head>
    <!--    <meta http-equiv="Refresh" content="2">-->
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<br>


<div class="tab">
    <button class="tablinks" onclick="openCity(event, 'tsqtab')" >Verification </button>
</div>

<div id="tsqtab" class="tabcontent">
    <div>
        <h1>VERIFY</h1>
        <h2>Verification with ".TSQ" and ".TSR" files:</h2> <br><br>
        <form method="POST" enctype="multipart/form-data" action="index.php">
            Select the ".TSQ" file:
            <input type="file" name="tsq">
            Select the ".TSR" file:
            <input type="file" name="tsr">


            <input class="button" type="submit" name="verify_tsq" value="Verify">

        </form>
    </div>
</div>
<div class="gradient">

    <?php

    if(isset($_POST['verify_tsq']))
    {
        $errorMassage = '';

        if ($_FILES['tsq']['tmp_name'] == '')
            echo $errorMassage = 'Please select the ".tsq" file?';

        else if ($_FILES['tsr']['tmp_name'] == '')
            echo $errorMassage = 'Please select ".tsr" file?';

        else {
            $tsq_file = file_get_contents($_FILES['tsq']['tmp_name']);
            $tsr_file = file_get_contents($_FILES['tsr']['tmp_name']);

            $result = $tsa->verify_with_tsq_and_tsr($tsq_file,$tsr_file);

            $user = $tsa->user_details(sha1($tsq_file));
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