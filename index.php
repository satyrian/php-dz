<?php
function calcCredit($creditSum, $payout, $bankName, $percent, $servicePayment, $openingAccountPayment) {
    $creditSum += $openingAccountPayment;
    $paymentTotal = 0 + $openingAccountPayment;

    for ($month = 0; $creditSum > 0; $month ++) {
        $creditSum = ($creditSum * $percent) + $servicePayment;
        if ($creditSum < $payout) {
            $paymentTotal += $creditSum;
            $creditSum -= $creditSum;
        } else {
            $creditSum -= $payout;
            $paymentTotal += $payout;
        }
    }

    $paymentTotal = round($paymentTotal, 2);
    return [
        "bankName" => $bankName,
        "paymentTotal" => $paymentTotal,
        "month" => $month
    ];
}

$creditOffers = [
    "homoCredit"     => ["Homo Credit", 1.04, 500, 0],
    "softBank"       => ["Soft Bank", 1.03, 1000, 0],
    "strawberryBank" => ["Strawberry Bank", 1.02, 0, 7777],
];
$creditSum = 39999;
$payout = 5000;
$bestOffer = "";
$minTotalPayment = 9999999;

foreach ($creditOffers as $offer) {
    $bankResult = calcCredit($creditSum, $payout, ...$offer);
    echo "Использовав банк {$bankResult["bankName"]}, школьник заплатит {$bankResult["paymentTotal"]} за {$bankResult["month"]} месяцев\n";

    if ($bankResult["paymentTotal"] < $minTotalPayment) {
        $minTotalPayment = $bankResult["paymentTotal"];
        $bestOffer = $bankResult["bankName"];
    }
}

echo "Самое выгодное предложение в банке $bestOffer";
