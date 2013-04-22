<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

include_once 'file.php';
$ObjFile = new File();
if ($ObjFile->CheckSession()){
    header("location:list_files.php");
}

?>
<html>
    <head>
        <title>Register</title>
        <style type="text/css">
        body,td,th {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
        }
        </style>
    </head>
    <body>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <table align="center" border="1" width="400">
            <tr>
                <td>
                    <form method="post" name="frm" action="process_register.php">
                        <table align="center">
                            <tr>
                                <td colspan="2" align="center"><h3>Register</h3></td>
                            </tr>
                            <tr>
                                    <td width="80">User Name</td>
                                    <td><input type="text" name="user" maxlength="15"/></td>
                            </tr>
                            <tr>
                                    <td>Password</td>
                                    <td><input type="password" name="pass"  maxlength="15"/></td>
                            </tr>
                            <tr>
                                    <td></td>
                                    <td><img src="captcha.php" width="75" height="25"/></td>
                            </tr>
                            <tr>
                                    <td></td>
                                    <td><input type="text" name="captcha" maxlength="5"/></td>
                            <tr>
                                    <td></td>
                                    <td><input type="submit" name="register" value="Register" /></td>
                            </tr>
                            <tr>
                                    <td></td>
                                    <td><a href="index.php">Login?</a></td>
                            </tr>
                            <tr>
                                    <td></td>
                                    <td><font color="#F00"><b><?php echo $_SESSION["pesan"]; unset($_SESSION["pesan"]);?></b></font></td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>