<?php

function calculateDong (array $shares): array {
  $total = array_sum($shares);
  $negatives = [];
  $positives = [];
  $res = [];

  $sharePerPerson = $total / count($shares);

  foreach ($shares as $key => $value) {
    $difference = $value - $sharePerPerson;
    if ($difference < 0) {
      $negatives[$key] = $difference;
    } else {
      $positives[$key] = $difference;
    }
  }

  ksort($negatives);
  ksort($positives);

  foreach ($negatives as $nKey => $temp1) {
    foreach ($positives as $pKey => $temp2) {
      if ($negatives[$nKey] !== 0 && $positives[$pKey] !== 0) {

        $transferAmount = min(abs($negatives[$nKey]), $positives[$pKey]);

        $resKey = $nKey . " to " . $pKey;

        $res[$resKey] = $transferAmount;

        $negatives[$nKey] += $transferAmount;

        $positives[$pKey] -= $transferAmount;

      }
    }
  }

  return $res;
}
$shares = ["a" => 0, "b" => 320, "c" => 0, "d" => 0, "e" => 410];

print_r(calculateDong($shares));