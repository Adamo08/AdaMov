
<?php 
    if (session_status() === PHP_SESSION_NONE){
        session_start();
    }
?>

<pre>
    Test
    <br>
    <?php 

        echo @$success;
        echo @$error;

        echo @$id;
        echo @$fname;
        echo @$lname;

        print_r($_SESSION);

    ?>
</pre>

