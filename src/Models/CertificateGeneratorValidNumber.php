<?php


namespace CertificateGenerator\Models;


class CertificateGeneratorValidNumber
{

    public function generateBirthCertificateNumber(array $data) : String
    {
        $prefixNumber = '';
        $prefixNumber .= str_pad($data['cns'], 6, 0, STR_PAD_LEFT)
            . $data['acquis_code']
            . $data['company_type_code']
            . $data['year']
            . $data['book_type']
            . str_pad($data['book_number']/*user set*/, 5, 0, STR_PAD_LEFT)
            . str_pad($data['book_page'], 3, 0, STR_PAD_LEFT)
            . str_pad($data['index'], 7, 0, STR_PAD_LEFT);

        $firstDig = 0;
        for ($i = 0, $j = 2; $i < strlen($prefixNumber); $i++, $j++) {
            $firstDig += $prefixNumber[$i] * $j;
            if ($j == 10) {
                $j = -1;
            }
        }

        $firstDig = $firstDig % 11 != 10 ? $firstDig : 1;
        $prefixNumber .= $firstDig;
        $secondDig = 0;
        for ($i = 0, $j = 1; $i < strlen($prefixNumber); $i++, $j++) {
            $secondDig += $prefixNumber[$i] * $j;
            if ($j == 10) {
                $j = -1;
            }
        }
        return $prefixNumber . ($secondDig % 11);
    }
}
