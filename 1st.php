<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * @author warunaoshan@gmail.com>
 */


/**
 * 
 * {"clientID":"c001","token":"29fe5623a02b5ebcf38a6266824b5a5e","PhoneNumber":"94772189584","Message":"Hello","Date":"2013-01-09","Time":"10:30"}
 * 
 * 
 */

if (isset($_POST['token'])) {

    $str = $_REQUEST['data'];
    $json = json_decode($str, TRUE);

    if (hash('md5', 'ceylonlinux') === $json['token']) {
        if (!is_dir('userdetails/')) {
            mkdir('./userdetails/', 0777, TRUE);
        }

        $myFile = './userdetails/' . $json['clientID'] . '_' . $json['Date'] . $json['Time'] . '.txt';
        if (file_exists($myFile)) {
            echo json_encode(array("status" => FALSE));
            exit();
        }
        $fopen = fopen($myFile, "w+");

        $info = 'To: ' . $json['PhoneNumber'] . " \n\n" . $json['Message'];
        fwrite($fopen, $info);
        $fclose = fclose($fopen);
        echo json_encode(array("status" => $fclose));
    } else {
        echo json_encode(array("status" => 's'));
    }
} else {
    echo json_encode(array("status" => FALSE));
}
?>
