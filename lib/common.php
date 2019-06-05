<?php

function trigger_mysql_error($level,$message,$details,$file,$line) {
    $error = new Error();
    $properties = array(
        'date'      => date('Y-m-d H:i:s'),
        'level'     => $level,
        'message'   => $message,
        'details'   => $details,
        'file'      => $file,
        'line'      => $line
    );
    $error->save($properties);
}

function check_required($array,$required) {
    foreach($required as $field=>$pattern) {
        if (
                !isset($array[$field])
            or
                trim($array[$field])==''
            or (
                    $pattern!=''
                and
                    !preg_match($pattern,trim($array[$field]))
                )
            ){
            return false;
        }
    }
    return true;
}

//*******    To SQL query
function clean_input( $text) {
    if ( is_string($text) ) {
        $text = trim($text);
        if ( mysql_real_escape_string("test_string") ) {
             $text = mysql_real_escape_string($text);
        }
        else {
             $text = addslashes($text);
        }
    }
    return $text;
}

//*******    From SQL query
function clean_output($text , $noquotes=0) {
    if ( get_magic_quotes_runtime() ) {
        $text = stripslashes($text);
    }
    if ($noquotes) {
        $text = htmlspecialchars($text);
    }
    return $text;
}

function aes_encrypt($pass) {
     $pass = clean_input($pass);
     $q  = "SELECT AES_ENCRYPT('$pass','"._AES_KEYWORD."') as passwd";
     $res = mysql_query($q);
     $row = mysql_fetch_assoc($res);
     $pass_bin = $row['passwd'];
     return base64_encode($pass_bin);
}

function aes_decrypt($pass_encrypted) {
     $pass_bin = base64_decode($pass_encrypted);
     $pass_bin = mysql_real_escape_string($pass_bin);
     $q  = "SELECT AES_DECRYPT('$pass_bin','"._AES_KEYWORD."') as passwd";
     $res = mysql_query($q);
     $row = mysql_fetch_assoc($res);
     $pass = $row['passwd'];
     return $pass;
}

function foDate2dbDate($foDate) {
     $arr = explode('/',$foDate);
     if ( count($arr) == 3 ) {
          $dbDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
     }
     else {
          $dbDate = $foDate;
     }
     return $dbDate;
}

?>