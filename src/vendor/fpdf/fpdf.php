<?php

/**
 * FPDF - Free PDF generation
 * 
 * This is a simplified version of FPDF for demonstration purposes.
 * In production, you should download the full FPDF library from http://www.fpdf.org/
 */

class FPDF
{
    protected $page = 0;
    protected $fontFamily = 'Arial';
    protected $fontSize = 12;
    protected $fontStyle = '';
    protected $content = '';
    protected $currentTable = '';
    protected $inTable = false;
    protected $inRow = false;
    protected $header = '';
    protected $footer = '';
    protected $title = '';

    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        $this->title = 'Hóa Đơn';
    }

    function Header()
    {
        // Được ghi đè bởi lớp con
    }

    function Footer()
    {
        // Được ghi đè bởi lớp con
    }

    function AddPage()
    {
        $this->page++;
        // $this->content .= "<div class='page'><h2 class='page-header'>Trang {$this->page}</h2>";
        $this->Header();
    }

    function SetFont($family, $style = '', $size = 0)
    {
        $this->fontFamily = $family;
        $this->fontStyle = $style;
        if ($size > 0) $this->fontSize = $size;
    }

    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        // Start a new table if not already in one
        if (!$this->inTable) {
            $this->currentTable = "<table class='pdf-table'>";
            $this->inTable = true;
            $this->inRow = false;
        }

        // Start a new row if needed
        if (!$this->inRow) {
            $this->currentTable .= "<tr>";
            $this->inRow = true;
        }

        // Set styles
        $style = 'style="';
        if (strpos($this->fontStyle, 'B') !== false) $style .= 'font-weight:bold;';
        if (strpos($this->fontStyle, 'I') !== false) $style .= 'font-style:italic;';
        if (strpos($this->fontStyle, 'U') !== false) $style .= 'text-decoration:underline;';

        // Set border
        if ($border == 1) {
            $style .= 'border:1px solid #000;';
        }

        // Set alignment
        if ($align == 'C') $style .= 'text-align:center;';
        elseif ($align == 'R') $style .= 'text-align:right;';
        elseif ($align == 'L') $style .= 'text-align:left;';

        // Set width
        if ($w > 0) $style .= "width:{$w}px;";

        // Close style attribute
        $style .= '"';

        // Create cell
        $this->currentTable .= "<td {$style}>{$txt}</td>";

        // End row if needed
        if ($ln == 1) {
            $this->currentTable .= "</tr>";
            $this->inRow = false;
        }

        // If this is the last cell and we're done with the table
        if (!$this->inRow && $ln == 1) {
            $this->currentTable .= "</table>";
            $this->content .= $this->currentTable;
            $this->currentTable = '';
            $this->inTable = false;
        }
    }

    function Ln($h = null)
    {
        // If we're in the middle of a table row, close it
        if ($this->inTable && $this->inRow) {
            $this->currentTable .= "</tr>";
            $this->inRow = false;
        }
    }

    function SetY($y, $resetX = true)
    {
        // Giả lập để file chạy không lỗi
    }

    function PageNo()
    {
        return $this->page;
    }

    function AliasNbPages($alias = '{nb}')
    {
        // Giả lập để file chạy không lỗi
    }

    function Output($dest = '', $name = '', $isUTF8 = false)
    {
        // Make sure any open tables are closed
        if ($this->inTable) {
            if ($this->inRow) {
                $this->currentTable .= "</tr>";
            }
            $this->currentTable .= "</table>";
            $this->content .= $this->currentTable;
        }

        $this->content .= "</div>"; // Đóng page div

        // Thêm CSS style
        $style = "
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .invoice-container { max-width: 800px; margin: 0 auto; border: 1px solid #ccc; padding: 20px; }
            .page { border-bottom: 1px dashed #ccc; padding-bottom: 20px; margin-bottom: 20px; }
            .page:last-child { border-bottom: none; }
            .page-header { text-align: center; margin-bottom: 20px; }
            .invoice-header { text-align: center; margin-bottom: 30px; }
            .invoice-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
            
            .pdf-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
            .pdf-table td { padding: 8px; vertical-align: top; word-wrap: break-word; }
            
            .total-row { font-weight: bold; }
            .footer { text-align: center; font-style: italic; margin-top: 30px; }
        </style>
        ";

        $html = "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>{$this->title}</title>
            {$style}
        </head>
        <body>
            <div class='invoice-container'>
                <div class='invoice-header'>
                </div>
                {$this->content}
            </div>
        </body>
        </html>";

        // Trả về HTML thay vì PDF
        header('Content-Type: text/html; charset=utf-8');
        echo $html;

        return '';
    }
}