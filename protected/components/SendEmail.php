<?php
if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class SendEmail extends CApplicationComponent
{

	public function sendPdfEmail($from,$to,$renderPartial,$footer,$filename,$css,$paper='A4',$body='',$subject='',$cc='')
    {

		# mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', $paper);

        $mPDF1->defaultfooterline=0;//remove footer line

        $mPDF1->SetFooter($footer);//set footer 

        # Load a stylesheet
        $stylesheet = file_get_contents($css);
        $mPDF1->WriteHTML($stylesheet, 1);

        // # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($renderPartial);

		$content_PDF = $mPDF1->Output($filename.'.pdf','F');

        $message = new YiiMailMessage;

        $message->subject = $subject;
        $message->setBody($body, 'text/html');                
        $message->addTo($to);
        $message->from = $from;

        $swiftAttachment = Swift_Attachment::fromPath($filename.'.pdf',$content_PDF);  

        $message->attach($swiftAttachment);  

        if($cc!='')
        {
            $message->addCc($cc);    
        }

        
        $is_sent=Yii::app()->mail->send($message);  

        return $is_sent;
	}

    public function sendTextEmail($from,$to,$subject='',$body='',$cc='')
    {
        $message            = new YiiMailMessage;

        $message->subject    = $subject;
        $message->setBody($body, 'text/html');                
        $message->addTo($to);
        $message->from = $from; 

        if($cc!='')
        {
            $message->addCc($cc);    
        }
        
        $is_sent=Yii::app()->mail->send($message);  
        
        return $is_sent;
    }

}

?>