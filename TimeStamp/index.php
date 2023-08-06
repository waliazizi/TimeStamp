<html>
<head>
<!--    <meta http-equiv="Refresh" content="2">-->
    <link rel="stylesheet" href="style.css" type="text/css"/>

<!--    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">-->
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
<!--    <meta name="HandheldFriendly" content="true">-->
</head>
<body>
<h2 class="header" >Trusted Time Stamp Authority</h2>

<p style="text-align: center">
    Time Stamp Authority provides a free Time Stamp Service. Add a trusted timestamp to code
    or to an electronic signature with a digital seal of data integrity and a trusted date and time.
</p>

<?php
include "dbconfig.php";
include "Stamp.php";
include "Verify_with_tsq.php";
include "Verify_original.php";
?>

<br><br><br><br>


<script>

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" tabcontent", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
</body>
</html>
