<?php
namespace App\Solid\Interfaces;

interface SubSystemPoReceivedCategoryInterface
{
    public function viewSubsystemPoReceivedCategory();
    public function createUpdateSubsystemPoReceivedCategory($get_subsystem_po_received_category_id, array $request, $rapidx_name);
    public function getSubsystemPoReceivedCategoryInfoById($get_category_id);
    public function changeSubSystemPoReceivedCategoryStatus(array $request);
}