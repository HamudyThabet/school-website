<?php
//db reuired here


//asdasdsasadasdaa
include "Header.php";
?>
<h2>Contact Us</h2>
<!--<?php //if ($success): ?><p style="color:green"><?=// $success ?></p><?php //endif; ?> -->
<form method="post">
  <label>Name</label><input name="name" required>
  <label>Email</label><input type="email" name="email" required>
  <label>Message</label><textarea name="message"></textarea>
  <button type="submit">Send</button>
</form>
<?php include "Footer.php"; ?>
