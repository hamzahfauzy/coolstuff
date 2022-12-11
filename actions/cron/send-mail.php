<?php
echo "START CRON\n";
// check if file exists
$parent_path = '';
if (!in_array(php_sapi_name(),["cli","cgi-fcgi"])) {
    $parent_path = 'public/';
}

if(file_exists($parent_path . 'lock.txt'))
{
    die();
}

file_put_contents($parent_path . 'lock.txt', strtotime('now'));

try {
    //code...
    require 'helpers/QueryBuilder.php';

    $mysql = new QueryBuilder("mysql");
    
    $jobs = $mysql->select('email_queues')->where('status','waiting')->get();
    
    if(!empty($jobs) && count($jobs))
    {
        foreach($jobs as $job)
        {
            echo "SEND EMAIL TO ".$job['email']."\n";
            $mail = new Mailer();
            $mail->doSend($job['email'],$job['subject'],$job['message']);
            $mysql->update('email_queues', [
                'status' => 'executed',
                'sent_at' => date('Y-m-d H:i:s')
            ])->where('id',$job['id'])->exec();
            echo "MAIL SENT\n";
        }
    }
} catch (\Throwable $th) {
    //throw $th;
}

unlink($parent_path . 'lock.txt');
echo "FINISH CRON\n";