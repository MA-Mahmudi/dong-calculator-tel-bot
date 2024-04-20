<?php

function calculateDong(array $shares): array
{
    $total = array_sum($shares);
    $negatives = [];
    $positives = [];
    $res = [];

    $sharePerPerson = round($total / count($shares));
    $res["دنگ هر نفر"] = $sharePerPerson;

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

                $resKey = $nKey . " => " . $pKey;

                $res[$resKey] = $transferAmount;

                $negatives[$nKey] += $transferAmount;

                $positives[$pKey] -= $transferAmount;

            }
        }
    }
    return $res;
}
