<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 2016/10/28
 * Time: 10:33 AM
 */

require_once('DBConn_Dave.php');

function getAllALerts()
{
    global $dbConn;
    $sql = "SELECT * FROM TBL_ALERT";
    $stmt = $dbConn->prepare($sql);
    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }

}

function getNotification($notificationid)
{
    global $dbConn;
    $sql = "SELECT * FROM TBL_ALERT WHERE ALERT_ID = ?";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $notificationid);
    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }

}

function createNotification($alertData)
{

    global $dbConn;
    $sql = "INSERT INTO TBL_ALERT(TITLE, BODY, DESCRIPTION) VALUES(?,?,?)";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $alertData['TITLE']);
    $stmt->bindParam(2, $alertData['BODY']);
    $stmt->bindParam(3, $alertData['DESCRIPTION']);

    if ($stmt->execute()) {
        return true;
    } else {
        print_r($stmt->errorInfo());
        die();

    }
}

function sendNotificationGlobal($title, $message)
{
    $fields = array(
        'message' => array(
            'title' => $title,
            'body' => $message
        ),
        'to' => "bk3RNwTe3H0:CI2k_HHwgIpoDKCIZvvDMExUdFQ"
    );

    $fields = json_encode ( $fields );

    $headers = array (
            'Authorization: key=' . $GLOBALS['FCMServerKey'],
            'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $GLOBALS['FCMurl'] );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    //echo $result;
    curl_close ( $ch );

    $jsonResult = json_decode($result, true);

    //parse the results field and replace ids where neccessary


    var_dump($jsonResult);

    if(isset($jsonResult) && $jsonResult['success'] === 0)
    {
        $_SESSION['alert']['message_type'] = "alert-danger";
        $_SESSION['alert']['message_title'] = "Warning!";
        $_SESSION['alert']['message'] = "There was an error sending the notification. " . "$result";
        //header('Location: ../notifications.php');
        exit();
    }


}

function sendNotificationSpecific($title, $message, $arrUser)
{
    
}