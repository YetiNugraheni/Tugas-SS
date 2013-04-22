<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

include_once 'file.php';
$ObjFile = new File();
if (!$ObjFile->CheckSession()){
    header("location:index.php");
} else {
    $ObjFile->ResetSession();
}


?>
<html>
    <head>
        <title>List Of Files</title>
        <style type="text/css">
            body,td,th {
                    font-family: Arial, Helvetica, sans-serif;
                    font-size: 12px;
            }
        </style>
    </head>
    <body>
        <p>&nbsp;</p>
        <table align="center" border="1" width="600">
            <tr>
                <td>
                    <table align="center">
                        <tr>
                            <td align="right">Login as "<?php echo $ObjFile->GetUserName(); ?>" | <a href="logout.php">Logout</a></td>
                        </tr>
                        <tr>
                            <td align="left"><strong>List Of Files</strong></td>
                        </tr>
                        <tr>
                            <td align="left">
                                <table width="560" border="1">
                                    <tr>
                                      <td width="20">No</td>
                                      <td>File Name</td>
                                      <td width="80">Action</td>
                                    </tr>
                                    <?php
                                    $data = $ObjFile->GetListOfFiles();
                                    for ($i=0; $i < count($data); $i++){
                                        echo "<tr>
                                           <td>".($i+1)."</td> 
                                           <td>".$data[$i]."</td>
                                          <td>
                                          <table><tr><td>
                                          <form method='post' name='edt' action='edit_file.php'>
                                          <input type='hidden' name='filename' value='".$data[$i]."'/>
                                          <input type='submit' name='edit' value='Edit' /> </form>
                                          </td><td>
                                              <a href='delete_file.php?id=".trim($data[$i]).
                                                "' onclick='return confirm(\"Are you sure you want to delete?\")'>
                                          <input type='button' name='del' value='Delete' /> </a>
                                          </td></tr></table>
                                          </td></tr>";
                                    }                                    
                                    ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <form method="post" name="frm" action="create_file.php">
                                    File Name :<br>
                                    <input name="filename" type="text" maxlength="10" /> No whitespace or special characters (max : 15 characters).<br>
                                    <img src="captcha.php" width="75" height="25"/> <br>
                                    <input type="text" name="captcha" maxlength="5" size="5"/> <br>
                                    <input type="submit" name="create" value="Create" /> <br>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td><font color="#F00"><b><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);?></b></font></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>