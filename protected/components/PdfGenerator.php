<?php
if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class PdfGenerator extends CApplicationComponent
{


	public function PdfCreate($render,$renderPartial,$paper='A4'){

		# mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('hello', $paper);

        # render (full page)
        // $mPDF1->WriteHTML($render);

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/receipt.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        // # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($renderPartial);

        // # Renders image
        // $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
        return $mPDF1->Output();

	}

	public function PdfToEmail($subject,$from,$to,$content,$body,$paper='A4'){

		# mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', $paper);

        # render (full page)
        //$mPDF1->WriteHTML($this->render($content, array(), true));

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        // # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($content);

        // # Renders image
        $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
        // $mPDF1->Output();

		$content_PDF = $mPDF1->Output('', EYiiPdf::OUTPUT_TO_STRING);

        require_once(dirname(__FILE__).'/pjmail/pjmail.class.php');

        $mail = new PJmail();
        $mail->setAllFrom($from, "My personal site");
        $mail->addrecipient($to);
        $mail->addsubject($subject);
        $mail->text = $body;
        $mail->addbinattachement("my_document.pdf", $content_PDF);
        $res = $mail->sendmail();

        return $res;

	}

}

?>