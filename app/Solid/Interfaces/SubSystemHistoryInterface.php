<?php
namespace App\Solid\Interfaces;

interface SubSystemHistoryInterface
{
    public function viewSubsystemRequestHistory();
    public function export($category);
    public function import($rapidx_name);
    public function subsystemRequestCreateUpdate($get_subsystem_request_id, array $request, $rapidx_name);
    public function getSubSystemRequestInfoById($get_request_id);
    public function getPoReceivedDetails($subsystem_request_order_no);
}