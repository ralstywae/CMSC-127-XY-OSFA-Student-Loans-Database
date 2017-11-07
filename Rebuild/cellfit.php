

<?php
require('fpdf.php');

class FPDF_CellFit extends FPDF {

    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
    }

    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }

    function Header()
{
    $this->SetFont('Helvetica','',25);
    $this->SetFontSize(40);
    //Move to the right
    //$this->Cell(80);
    //Line break
    $this->Ln();
}

//Page footer
function Footer()
{
   
}

//Load data
function LoadData($file)
{
    //Read file lines
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
}

//Simple table
function BasicTable($header,$data)
{ 
//$pdf = new FPDF_CellFit();
$this->SetFillColor(255,255,255);
//$this->SetDrawColor(255, 0, 0);
$w=array(25,25,15,30,10,10,25,25,25,25,25,25,25,25,25,25);
    
    //Header
    $this->SetFont('Arial','B',9);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],0,0,'C',1);
    $this->Ln();
    
    //Data
    $this->SetFont('Arial','',10);
    foreach ($data as $eachResult) 
    { //width
        //$pdf->Cell(10);
        for ($j = 1; $j <= 2; $j++){
            $eachResult["Scho_type"].=' '.$eachResult["Scho_type"];
            $eachResult["Status"].=' '.$eachResult["Status"];
            $eachResult["Year_estab"].=' '.$eachResult["Year_estab"];
            $eachResult["Scho_title"].=' '.$eachResult["Scho_title"];
            $eachResult["Slot"].=' '.$eachResult["Slot"];
            $eachResult["Grantees"].=' '.$eachResult["Grantees"];
            $eachResult["Coverage"].=' '.$eachResult["Coverage"];
            $eachResult["Degree_program"].=' '.$eachResult["Degree_program"];
            $eachResult["Fund_mgt"].=' '.$eachResult["Fund_mgt"];
            $eachResult["Fund_source"].=' '.$eachResult["Fund_source"];
            $eachResult["School_fees"].=' '.$eachResult["School_fees"];
            $eachResult["Tuition"].=' '.$eachResult["Tuition"];
            $eachResult["Stipend"].=' '.$eachResult["Stipend"];
            $eachResult["Book_allowance"].=' '.$eachResult["Book_allowance"];
            $eachResult["Transpo_allowance"].=' '.$eachResult["Transpo_allowance"];
            $eachResult["Others"].=' '.$eachResult["Others"];
        }

        $this->CellFitScale(0,10,$eachResult["Scho_type"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Status"],1, 1,'',1);
        $this->CellFitScale(0,10,$eachResult["Year_estab"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Scho_title"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Slot"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Grantees"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Coverage"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Degree_program"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Fund_mgt"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Fund_source"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["School_fees"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Tuition"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Stipend"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Book_allowance"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Transpo_allowance"],1,1,'',1);
        $this->CellFitScale(0,10,$eachResult["Others"],1,1,'',1);
        $this->Ln();
                        
    }
}



function WordWrap(&$text, $maxwidth)
{
    $text = trim($text);
    if ($text==='')
        return 0;
    $space = $this->GetStringWidth(' ');
    $lines = explode("\n", $text);
    $text = '';
    $count = 0;

    foreach ($lines as $line)
    {
        $words = preg_split('/ +/', $line);
        $width = 0;

        foreach ($words as $word)
        {
            $wordwidth = $this->GetStringWidth($word);
            if ($wordwidth > $maxwidth)
            {
                // Word is too long, we cut it
                for($i=0; $i<strlen($word); $i++)
                {
                    $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                    if($width + $wordwidth <= $maxwidth)
                    {
                        $width += $wordwidth;
                        $text .= substr($word, $i, 1);
                    }
                    else
                    {
                        $width = $wordwidth;
                        $text = rtrim($text)."\n".substr($word, $i, 1);
                        $count++;
                    }
                }
            }
            elseif($width + $wordwidth <= $maxwidth)
            {
                $width += $wordwidth + $space;
                $text .= $word.' ';
            }
            else
            {
                $width = $wordwidth + $space;
                $text = rtrim($text)."\n".$word.' ';
                $count++;
            }
        }
        $text = rtrim($text)."\n";
        $count++;
    }
    $text = rtrim($text);
    return $count;
}

}
?>