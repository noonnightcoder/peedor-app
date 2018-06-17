<?php
if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class PdfGenerator extends CApplicationComponent
{


	public function PdfCreate($renderPartial,$paper='A4',$css,$filename='peedor'){

		/*
			- renderPartial parameter: a part of page wish to export
			- $paper parameter: paper style A4, A5, ...
			- $css parameter: full path of stylesheet that will style the page to write into pdf file

			***Why renderPartial: because when render full page mpdf have problem with some css property
			and cause error when call function WriteHTML***
	
		*/

		# mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', $paper);

        # render (full page)
        // $mPDF1->WriteHTML($render);

        # Load a stylesheet
        $stylesheet = file_get_contents($css);
        $mPDF1->WriteHTML($stylesheet, 1);

        // # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($renderPartial);

        // # Renders image
        // $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
        return $mPDF1->Output($filename,'I');

	}

	public function PdfToEmail($subject,$from,$to,$renderPartial,$filename,$body,$paper='A4',$css){

		# mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', $paper);

        # render (full page)
        //$mPDF1->WriteHTML($this->render($content, array(), true));

        # Load a stylesheet
        $stylesheet = file_get_contents($css);
        $mPDF1->WriteHTML($stylesheet, 1);

        // # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($renderPartial);

        // # Renders image
        // $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
        // $mPDF1->Output();

		$content_PDF = $mPDF1->Output($filename.'.pdf');

        $message            = new YiiMailMessage;
        $message->subject    = $subject;
        $message->setBody($body, 'text/html');                
        $message->addTo($to);
        $message->from = $from;  
        // $swiftAttachment = Swift_Attachment::fromPath(Yii::getPathOfAlias('webroot.css').'/main.css');
        $swiftAttachment = Swift_Attachment::fromPath($filename.'.pdf',$content_PDF);              
        $message->attach($swiftAttachment);
        $res=Yii::app()->mail->send($message);
        return $res;

	}

}

?>