<?php


namespace CertificateGenerator;


class CertificateGeneratorValidNumber
{

    private $cns;
    private $acquisCode;
    private $companyTypeCode;
    private $year;
    private $bookType;
    private $bookNumber;
    private $bookPage;
    private $index;

    /**
     * CertificateGeneratorValidNumber constructor.
     * @param $cns
     * @param $acquisCode
     * @param $companyTypeCode
     * @param $year
     * @param $bookType
     * @param $bookNumber
     * @param $bookPage
     * @param $index
     */
    public function __construct($cns, $acquisCode, $companyTypeCode, $year, $bookType, $bookNumber, $bookPage, $index)
    {
        $this->cns = $cns;
        $this->acquisCode = $acquisCode;
        $this->companyTypeCode = $companyTypeCode;
        $this->year = $year;
        $this->bookType = $bookType;
        $this->bookNumber = $bookNumber;
        $this->bookPage = $bookPage;
        $this->index = $index;
    }

    /**
     * @return mixed
     */
    public function getCns()
    {
        return $this->cns;
    }

    /**
     * @param mixed $cns
     */
    public function setCns($cns): void
    {
        $this->cns = $cns;
    }

    /**
     * @return mixed
     */
    public function getAcquisCode()
    {
        return $this->acquisCode;
    }

    /**
     * @param mixed $acquisCode
     */
    public function setAcquisCode($acquisCode): void
    {
        $this->acquisCode = $acquisCode;
    }

    /**
     * @return mixed
     */
    public function getCompanyTypeCode()
    {
        return $this->companyTypeCode;
    }

    /**
     * @param mixed $companyTypeCode
     */
    public function setCompanyTypeCode($companyTypeCode): void
    {
        $this->companyTypeCode = $companyTypeCode;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getBookType()
    {
        return $this->bookType;
    }

    /**
     * @param mixed $bookType
     */
    public function setBookType($bookType): void
    {
        $this->bookType = $bookType;
    }

    /**
     * @return mixed
     */
    public function getBookNumber()
    {
        return $this->bookNumber;
    }

    /**
     * @param mixed $bookNumber
     */
    public function setBookNumber($bookNumber): void
    {
        $this->bookNumber = $bookNumber;
    }

    /**
     * @return mixed
     */
    public function getBookPage()
    {
        return $this->bookPage;
    }

    /**
     * @param mixed $bookPage
     */
    public function setBookPage($bookPage): void
    {
        $this->bookPage = $bookPage;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param mixed $index
     */
    public function setIndex($index): void
    {
        $this->index = $index;
    }

    public function generateCertificateNumber($format = false) : String
    {
        $prefixNumber = '';
        $prefixNumber .= str_pad($this->getCns(), 6, 0, STR_PAD_LEFT)
            . str_pad($this->getAcquisCode(), 2, 0, STR_PAD_LEFT)
            . str_pad($this->getCompanyTypeCode(), 2, 0, STR_PAD_LEFT)
            . $this->getYear()
            . $this->getBookType()
            . str_pad($this->getBookNumber(), 5, 0, STR_PAD_LEFT)
            . str_pad($this->getBookPage(), 3, 0, STR_PAD_LEFT)
            . str_pad($this->getIndex(), 7, 0, STR_PAD_LEFT);

        $firstDig = 0;
        for ($i = 0, $j = 2; $i < strlen($prefixNumber); $i++, $j++) {
            $firstDig += $prefixNumber[$i] * $j;
            if ($j == 10) {
                $j = -1;
            }
        }

        $firstDig = $firstDig % 11 != 10 ? $firstDig % 11 : 1;
        $prefixNumber .= $firstDig;
        $secondDig = 0;
        for ($i = 0, $j = 1; $i < strlen($prefixNumber); $i++, $j++) {
            $secondDig += $prefixNumber[$i] * $j;
            if ($j == 10) {
                $j = -1;
            }
        }

        if (!$format) {
            return $prefixNumber . ($secondDig % 11);
        }

        $certificateNumber = $prefixNumber . ($secondDig % 11);
        $formatCn = substr($certificateNumber, 0, 10) . ' ' .
            substr($certificateNumber, 11, 4) . ' ' .
            substr($certificateNumber, 12, 1) . ' ' .
            substr($certificateNumber, 13, 4) . ' ' .
            substr($certificateNumber, 17, 3) . ' ' .
            substr($certificateNumber, 20, 7) . ' ' .
            substr($certificateNumber, 27, 2);

        return $formatCn;
    }
}
