<?php
session_start();
session_unset(); // ✅ Saare session variables clear karo
session_destroy(); // ✅ Session delete karo
header("Location: SignUp_Login_Form.php"); // ✅ Login page pe redirect
exit();

?>
