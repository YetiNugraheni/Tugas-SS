<?php
class File{    
    public $fileUser = "../../conf/user.txt";
    public $fileSession = "../../conf/session.txt";
    public $fileDoc = "../../conf/dokumen.txt";
    public $fileFolder = "../../conf/file/";
    
    function CheckUser ($user){
        /* @var $fUser File */
        $fUser = fopen($this->fileUser, "r");
        $check = true;
        while(true)
        {            
            $line = fgets($fUser);
            if($line == null)break;
            $lineEx=explode("<>", $line);
            if ($lineEx[0]==$user)
                $check = false;
        }
        
        fclose($fUser);
        return $check;
    }
    
    function InsertUser ($user, $pass){
        /* @var $fUser File */
        $fUser = fopen($this->fileUser, "a");
        fwrite($fUser, $user."<>".MD5($pass)."\n");
        $this->SetSession($user);
        fclose($fUser);
    }
    
    function SetSession ($user){
        /* @var $fSession File */
        include_once "character.php";
        $objChar = new Character();
    
        $fSession = fopen($this->fileSession, "a");
        $_SESSION["userID"] = MD5($objChar->GenerateSession());
        fwrite($fSession, $user."<>".$_SERVER['REMOTE_ADDR']."<>".$_SESSION["userID"]."\n");
         
        fclose($fSession);
    }
    
    function ResetSession(){
        /* @var $fSession File */
        include_once "character.php";
        $objChar = new Character();
        
        $userName = $this->GetUserName();
    
        $fSession = fopen($this->fileSession, "r");
        $data = "";
        while(true)
        {            
            $line = fgets($fSession);
            if($line == null)break;
            $lineEx=explode("<>", $line);
            if ($lineEx[0]!=$userName)
                $data = $data.$line;
        }        
        fclose($fSession);
        
        $fSession = fopen($this->fileSession, "w");
        $_SESSION["userID"] = MD5($objChar->GenerateSession());
        fwrite($fSession, $data.$userName."<>".$_SERVER['REMOTE_ADDR']."<>".$_SESSION["userID"]."\n");
         
        fclose($fSession);
    }
    
    function DeleteSession(){
        /* @var $fSession File */
        include_once "character.php";
        $objChar = new Character();
        
        $userName = $this->GetUserName();
    
        $fSession = fopen($this->fileSession, "r");
        $data = "";
        while(true)
        {            
            $line = fgets($fSession);
            if($line == null)break;
            $lineEx=explode("<>", $line);
            if ($lineEx[0]!=$userName)
                $data = $data.$line;
        }        
        fclose($fSession);
        
        $fSession = fopen($this->fileSession, "w");
        fwrite($fSession, $data);         
        fclose($fSession);
    }
    
    function CheckSession (){
        /* @var $fSession File */    
        $fSession = fopen($this->fileSession, "r");
        $check = false;
        while(true)
        {            
            $line = fgets($fSession);
            if($line == null)break;
            $lineEx=explode("<>", $line);
            if ($lineEx[1]==$_SERVER['REMOTE_ADDR'] && strcmp(substr($lineEx[2],0,32),substr($_SESSION["userID"],0,32))==0){
                $check = true;
            }
        }
        
        fclose($fSession);
        return $check;
    }
    
    function GetUserName (){
        /* @var $fSession File */    
        $fSession = fopen($this->fileSession, "r");
        $check = "";
        while(true)
        {            
            $line = fgets($fSession);
            if($line == null)break;
            $lineEx=explode("<>", $line);
            if ($lineEx[1]==$_SERVER['REMOTE_ADDR'] && strcmp(substr($lineEx[2],0,32),substr($_SESSION["userID"],0,32))==0){
                $check = $lineEx[0];
            }
        }
        
        fclose($fSession);
        return $check;
    }
    
    function CheckFile ($fileName){
        /* @var $fDoc File */
        if ($this->CheckSession()){
            $fDoc = fopen($this->fileDoc, "r");
            $check = true;
            while(true)
            {            
                $line = fgets($fDoc);
                if($line == null)break;
                $lineEx=explode("<>", $line);
                if (strcmp(substr($lineEx[1],0,strlen($fileName)), substr($fileName,0,strlen($fileName)))==0){
                    $check = false;
                }

            }
            fclose($fDoc);
            return $check;
        }
    }
    
    function CreateFile ($fileName){
        /* @var $fDoc File */ 
        if ($this->CheckSession()){
            $fDoc = fopen($this->fileDoc, "a");
            fwrite($fDoc, $this->GetUserName()."<>".$fileName."\n");         
            fclose($fDoc);

            $fDoc = fopen($this->fileFolder.$fileName.".txt", "w");
            fwrite($fDoc, "");
            fclose($fDoc);  
        }
    }
    
    function GetListOfFiles (){
        /* @var $fDoc File */ 
        if ($this->CheckSession()){
            $fDoc = fopen($this->fileDoc, "r");
            $i = 0;
            $userName=$this->GetUserName();
            while(true)
            {            
                $line = fgets($fDoc);
                if($line == null)break;
                $lineEx=explode("<>", $line);
                if ($lineEx[0]==$userName){
                    $data[$i] = $lineEx[1];
                    $i++;
                }
            }

            fclose($fDoc);
            return $data;
        }
    }
    
    function CheckValidFile ($fileName){
        /* @var $fDoc File */
        if ($this->CheckSession()){
            $fDoc = fopen($this->fileDoc, "r");
            $check = false;
            $userName=$this->GetUserName();
            $length = strlen(trim($fileName));
            while(true)
            {            
                $line = fgets($fDoc);
                if($line == null)break;
                $lineEx=explode("<>", $line);
                if (strcmp(substr($lineEx[1],0,$length), substr($fileName,0,$length))==0 && 
                        $lineEx[0]==$userName){
                    $check = true;
                }

            }
            fclose($fDoc);
            return $check;
        }
    }
    
    function CheckFileContent ($fileName){
        /* @var $fDoc File */
        if ($this->CheckSession()){
            $fileName = trim($fileName);
            $fDoc = fopen($this->fileFolder.$fileName.".txt", "r");
            $data = "";
            while(true)
            {            
                $line = fgets($fDoc);
                if($line == null)break;
                $data = $data.$line;            
            }
            fclose($fDoc);
            return $data;
        }
    }
    
    function SaveFile ($content, $fileName){
        /* @var $fDoc File */
        if ($this->CheckSession()){
            $fileName = trim($fileName);
            $fDoc = fopen($this->fileFolder.$fileName.".txt", "w");
            fwrite($fDoc, $content);         
            fclose($fDoc);
        }
    }
    
    function DeleteFile ($fileName){
        /* @var $fDoc File */
        if ($this->CheckSession()){
            $fDoc = fopen($this->fileDoc, "r");
            $length = strlen(trim($fileName));
            $data = "";
            while(true)
            {            
                $line = fgets($fDoc);
                if($line == null)break;
                $lineEx=explode("<>", $line);
                if (strcmp(substr($lineEx[1],0,$length), substr($fileName,0,$length))!=0){
                    $data = $data.$line;
                }

            }
            fclose($fDoc);

            $fDoc = fopen($this->fileDoc, "w");
            fwrite($fDoc, $data);         
            fclose($fDoc);

            unlink($this->fileFolder.$fileName.".txt");
        }
    }
    
    function CheckValidUser ($userName, $pass){
        /* @var $fUser File */
        $fUser = fopen($this->fileUser, "r");
        $check = false;
        while(true)
        {            
            $line = fgets($fUser);
            if($line == null)break;
            $lineEx=explode("<>", $line);
            if ($lineEx[0]==$userName && trim($lineEx[1])==MD5($pass)){
                $check = true;
            }
        }
        fclose($fUser);
        return $check;
    }
}
?>