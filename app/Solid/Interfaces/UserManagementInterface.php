<?php
namespace App\Solid\Interfaces;

interface UserManagementInterface
{
    public function getUsers();
    public function getRapidxUserActiveInSystemOne();
    public function getSystemOneDepartment();
    public function getSystemOnePosition();
    public function userCreateUpdate($get_user_id, array $request);
    public function getUserInfoById($get_request_id);
    public function changeUserStatus(array $request);
    public function getUserLog($loginEmployeeId);
}