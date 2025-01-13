<?php

namespace App\Repositories\Reports;

interface ReportInterface
{
  public function getProductCartReport();
  public function SearchReport($reportType, $startAt, $endAt);
}
