<?php

$nilai = ['72', '65', '73', '78', '75', '74', '90', '81', '87', '65', 
'55', '69', '72', '78', '79' ,'91', '100', '40','67','77','86'];

$jumlah = count($nilai);
$nilai_rata = 0;

for ($i = 0; $i < $jumlah ; $i++)
{
  $nilai_rata = $nilai_rata + $nilai[$i];
  echo $nilai[$i].",";
}

$nilai_rata = $nilai_rata / $jumlah;
echo "<br/>";
echo "Nilai rata-rata dari array diatas adalah ". round($nilai_rata)."<br/>";
echo "Nilai tertinggi dari array diatas adalah ". max($nilai)."<br/>";
echo "Nilai terendah dari array diatas adalah ". min($nilai)."<br/>";

?>