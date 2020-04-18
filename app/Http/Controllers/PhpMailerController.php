<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class PhpMailerController extends Controller{

    public function sendMail(Request $request){


        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
            $mail->Username = config('services.env.EMAIL_SENDER');
            $mail->Password = config('services.env.EMAIL_SENDER_PWD');
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($mail->Username, 'liaderosa SENDER');
            $mail->addAddress(config('services.env.RECIPIENT'), 'liaderosa RECIPIENT');	// Add a recipient, Name is optional
            $mail->addReplyTo('noreply@fake.it', 'No Reply');
            #$mail->addCC('his-her-email@gmail.com');
            #$mail->addBCC('his-her-email@gmail.com');

            //Attachments (optional)
            $mail->addAttachment(storage_path('POOL_LOG020170405'));			// Add attachments
            #$mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Optional name

            //Content
            $mail->isHTML(true); 																	// Set email format to HTML
            $mail->Subject = 'Messaggio di proba php mailer';
            $mail->Body    = 'Questo è un messaggio di prova inviato alla mail lavorativa mediante php mailer controller';

            $outcome = $mail->send();
            dd($outcome);

        }
        catch(\Exception $e){
            Log::error($e->getMessage().';'.$e->getTraceAsString());
            dd('shit');

        }






    }
}
