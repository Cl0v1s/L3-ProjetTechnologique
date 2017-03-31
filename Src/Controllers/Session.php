<?php  

function sessionVariables(){
    if(isset($_SESSION["Admin"])){
        $data["admin"] = true;
        $data["user"] = false;
    }else{
        $data["admin"] = false;
        $data["user"] = true;
    }
    if(isset($_SESSION["User"])){
        $data["connected"] = true;
        $data["disconnected"] = false;
    }else{
        $data["disconnected"] = true;
        $data["connected"] = false;
    }
    return $data;
}

?>