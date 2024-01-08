<?php 

class WatermarkPDF extends FPDI {

    public $_tplIdx;
    public $angle = 0;
    public $fullPathToFile;
    public $rotatedText = '';

    function __construct($fullPathToFile, $rotate_text) {
        $this->fullPathToFile = $fullPathToFile;
        if ($rotate_text)
            $this->rotatedText = $rotate_text;
        parent::__construct();
    }


    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    function Header() {
        //Put the watermark
        $this->Image('http://203.107.156.180/intsys/it_system/asset/image/Master2.png', 40, 100, 100, 0, 'PNG');
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(120, 200, $this->rotatedText, 45);
        if ($this->fullPathToFile) {
            if (is_null($this->_tplIdx)) {
                // THIS IS WHERE YOU GET THE NUMBER OF PAGES
                $this->numPages = $this->setSourceFile($this->fullPathToFile);
                $this->_tplIdx = $this->importPage(1);
            }
            $this->useTemplate($this->_tplIdx, 0, 0, 200);
        }
    }

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

}
// $this->my_pdf->AddPage();

$file = "/IT-P-001.pdf";
$File = "../dc2/asset/document_files/Powerpoint2010.pdf";
$watermarkText = "";
$this->my_pdf = new WatermarkPDF($File, $watermarkText);
//$this->my_pdf = new FPDI();
$this->my_pdf->AddPage();
$this->my_pdf->SetFont('Arial', '', 12);



/*$txt = "FPDF is a PHP class which allows to generate PDF files with pure PHP, that is to say " .
        "without using the PDFlib library. F from FPDF stands for Free: you may use it for any " .
        "kind of usage and modify it to suit your needs.\n\n";
for ($i = 0; $i < 25; $i++) {
    $this->my_pdf->MultiCell(0, 5, $txt, 0, 'J');
}*/


if($this->my_pdf->numPages>1) {
    for($i=2;$i<=$this->my_pdf->numPages;$i++) {
        //$this->my_pdf->endPage();
        $this->my_pdf->_tplIdx = $this->my_pdf->importPage($i);
        $this->my_pdf->AddPage();
    }
}

$this->my_pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser
//$this->my_pdf->Output("sampleUpdated.pdf", 'D'); //Download the file. open dialogue window in browser to save, not open with PDF browser viewer
//$this->my_pdf->Output("save_to_directory_path.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
//$this->my_pdf->Output("sampleUpdated.pdf", 'I'); //I for "inline" to send the PDF to the browser
//$this->my_pdf->Output("", 'S'); //return the document as a string. filename is ignored.


 ?>