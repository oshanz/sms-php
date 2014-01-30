<?php

/**
 * @author Waruna Oshan Wisumperuma
 * @contact warunaoshan@gmail.com
 */
/**
 * 
 * 
  status = -100 message failed
  status = -200  Invalid Password
  status = -300 Empty arguments
  status = -400 null parameters
  status = -500 another message received at same time from same client
 * 
 */
/**
 * Form encoded json
 * {"clientID":"c001","token":"29fe5623a02b5ebcf38a6266824b5a5e","PhoneNumber":"94772189584","Message":"Hello","Date":"2013-01-09","Time":"10:30"}
 * 
 * 
 */
if (isset($_POST['clientID']) && isset($_POST['token']) && isset($_POST['PhoneNumber']) && isset($_POST['Message']) && isset($_POST['Date']) && isset($_POST['Time'])) {

    if (!empty($_POST['clientID']) && !empty($_POST['token']) && !empty($_POST['PhoneNumber']) && !empty($_POST['Message']) && !empty($_POST['Date']) && !empty($_POST['Time'])) {

        $userID = filter_input(INPUT_POST, 'clientID', FILTER_SANITIZE_STRING);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        $pN = filter_input(INPUT_POST, 'PhoneNumber', FILTER_SANITIZE_NUMBER_INT);
        $msg = filter_input(INPUT_POST, 'Message', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'Date');
        $time = filter_input(INPUT_POST, 'Time');

        if (hash('md5', 'ceylonlinux') === $token) {
            if (!is_dir('userdetails/')) {
                mkdir('./userdetails/', 0777, TRUE);
            }

            $myFile = './userdetails/' . $userID . '_' . $pN . '_' . $date . '_' . $time . '.txt';
            if (file_exists($myFile)) {
                echo json_encode(array("status" => -500));
                exit();
            }
            $fopen = fopen($myFile, "w+");
            $info = 'To: ' . $pN . " \n" . $msg;
            fwrite($fopen, $info);
            $fclose = fclose($fopen);

            echo json_encode(array("status" => $fclose === TRUE ? 100 : -100));
        } else {
            echo json_encode(array("status" => -200));
        }
    } else {
        echo json_encode(array("status" => -300));
    }
} else {
    echo json_encode(array("status" => -400));
}

