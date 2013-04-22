<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

include_once 'file.php';
$ObjFile = new File();
if (!$ObjFile->CheckSession()){
    header("location:index.php");
}

$ObjFile->CheckValidFile($_POST['filename']);
if (empty($_POST['filename']) || !$ObjFile->CheckValidFile($_POST['filename'])){
    header("location:list_files.php");
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
                            <td align="left"><strong>Edit File "<?php echo $_POST['filename'];?>"</strong></td>
                        </tr>
                        <tr>
                            <td align="left">
                                <form method="post" name="frm" action="save_file.php">
                                    <input type="hidden" name="filename" value="<?php echo trim($_POST['filename']);?>">
                                    <textarea name="filecontent" id="filecontent" cols="60" rows="15"><?php echo $ObjFile->CheckFileContent($_POST['filename']);
                                        ?></textarea> <br>
                                    <input type="submit" name="save" value="Save" /> <br>
                                </form>
                                <a href="list_files.php">Lift of files</a>
                                
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