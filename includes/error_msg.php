<?php
if (isset($errorH)) { ?>

    <div class=" alert alert-d rnd4">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <p>
            <?php echo $errorH; ?>
        </p>
    </div>

<?php }

if (isset($msg)) { ?>

    <div class="alert alert-s rnd4">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <p>
            <?php echo $msg; ?>
        </p>
    </div>

<?php
}
?>