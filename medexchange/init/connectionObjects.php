<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 28.05.2015
 * Time: 12:09
 */

require_once dirname(dirname(dirname(__DIR__))) . '/config.php';

$group = new Group();
$groupAngebotseingabe = $group->getGroupLKByName('Angebotseingabe');
$groupAngebotseinkauf = $group->getGroupLKByName('Angebotseinkauf');
$groupGesucheingabe = $group->getGroupLKByName('Gesucheingabe');
$groupGesuchverkauf = $group->getGroupLKByName('Gesuchverkauf');
$groupSammelbestellung = $group->getGroupLKByName('Sammelbestellung');

$permission = new permission();
$permissionAngebotseingabe = $permission->getPermissionLKByName('Angebotseingabe');
$permissionAngebotseinkauf = $permission->getPermissionLKByName('Angebotseinkauf');
$permissionGesucheingabe = $permission->getPermissionLKByName('Gesucheingabe');
$permissionGesuchverkauf = $permission->getPermissionLKByName('Gesuchverkauf');
$permissionSammelbestellung = $permission->getPermissionLKByName('Sammelbestellung');

$connections = [
    'ConnUserGroup' => [
        1 => [
            $groupAngebotseingabe,
            $groupAngebotseinkauf,
            $groupGesucheingabe,
            $groupGesuchverkauf,
            $groupSammelbestellung
        ]
    ],
    'ConnGroupRight' => [
         $groupAngebotseingabe => [$permissionAngebotseingabe],
         $groupAngebotseinkauf => [$permissionAngebotseinkauf],
         $groupGesucheingabe => [$permissionGesucheingabe],
         $groupGesuchverkauf => [$permissionGesuchverkauf],
         $groupSammelbestellung => [$permissionSammelbestellung],
    ]
];

foreach ($connections as $class => $data) {
    foreach ($data as $lkLeft => $lksRight) {
        foreach ($lksRight as $lkRight) {
            /** @var BaseConnectionObject $connObj */
            $connObj = new $class();
            $connObj->setLkLeft($lkLeft);
            $connObj->setLkRight($lkRight);

            DB::beginTransaction();
            try {
                $connObj->save();
            } catch (base_exception_BaseConnectionObject $e) {
                Logger::output('install.log', $e->getMessage());
            }
            DB::endTransaction();

        }
    }
}
