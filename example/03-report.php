<?php

include_once 'vendor/autoload.php';
include_once 'credentials.php';

use Grow\Client\ApiClient\ApiClientFactory;

$apiClient = ApiClientFactory::getInstance()->getClient(GROW_API_USERNAME, GROW_API_PASSWORD);

$year = 2015;
$report = $apiClient->getSGAFGRReferralAndDetection($year);
$pdfFilename = sprintf(
    "/tmp/SGAFGRReferralAndDetection-%s.pdf",
    $year
);
$report->savePdf($pdfFilename);

echo sprintf(
    "SGA FGR Referral And Detection PDF Report saved in '%s'\n",
    $pdfFilename
);
