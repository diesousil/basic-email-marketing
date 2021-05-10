<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email extends Model
{
    private function getMailerInstance() {
        
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                       //Enable verbose debug output
        $mail->isSMTP();                                             //Send using SMTP
        $mail->Host       = env('MAIL_HOST');                        //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                    //Enable SMTP authentication
        $mail->Username   = env('MAIL_USERNAME'); //SMTP username
        $mail->Password   = env('MAIL_PASSWORD');                     //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = env("MAIL_PORT");                        //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        // Set From
        $mail->setFrom('contato@movimentoforabolsonaro.com.br', 'Movimento Fora Bolsonaro');

        return $mail;

    }

    
    public function send() {
        
        $result = true;

        $destinations = [
            ["name"=>"Diego Silva","emailAddrees"=>"diesousil@gmail.com"],
            ["name"=>"Dalmiro","emailAddrees"=>"dal_sl@hotmail.com"]
        ];

        try {
            foreach($destinations as $destination) {
                $mail = $this->getMailerInstance();
                $mail->addAddress($destination["emailAddrees"], $destination["name"]);     //Add a recipient

                 //Content
                $mail->isHTML(true);                                  
                $mail->Subject = 'Teste de mensagem agendada!';
                $mail->Body    = '<h1>Testando...</h1> <br/><br/><p>Foi <b>disparado</b> através de um script de envio agendado com sucesso!</p>';
                $mail->AltBody = 'Testando...\n\nFoi disparado<através de um script de envio agendado com sucesso!';
            
                $result = $mail->send();
            }
           
            echo 'Messages has been sent';
        } catch (Exception $e) {
            $result = false;
            echo "Messages could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        return $result;
    }
}
