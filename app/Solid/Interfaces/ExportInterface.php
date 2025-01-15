<?php
namespace App\Solid\Interfaces;

interface ExportInterface
{
    public function searchPoReceivedDetails(array $request);
    public function export($category,$poNo,$deviceName,$from,$to);
}