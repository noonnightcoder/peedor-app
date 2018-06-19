<?php
if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class PdfGenerator extends CApplicationComponent
{


	public function PdfCreate($renderPartial,$footer,$css,$paper='A4',$filename='peedor')
    {

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

        $mPDF1->defaultfooterline=0;//remove footer line

        $mPDF1->SetFooter($footer);//set footer 
        

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

}

?>