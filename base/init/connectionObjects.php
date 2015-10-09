<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 28.05.2015
 * Time: 12:09
 */

require_once dirname(dirname(dirname(__DIR__))) . '/config.php';

$group = new Group();
$groupBenutzer = $group->getGroupLKByName('Benutzer');
$groupModerator = $group->getGroupLKByName('Moderator');
$groupAdministrator = $group->getGroupLKByName('Administrator');

$permission = new permission();
$permissionBenutzer = $permission->getpermissionLKByName('Benutzer');
$permissionModerator = $permission->getpermissionLKByName('Moderator');
$permissionAdministrator = $permission->getpermissionLKByName('Administrator');

$connections = [
    'ConnUserGroup' => [
        1 => [
            $groupBenutzer,
            $groupModerator,
            $groupAdministrator
        ]
    ],
    'ConnGroupRight' => [
         $groupBenutzer => [$permissionBenutzer],
         $groupModerator => [$permissionModerator],
         $groupAdministrator => [$permissionAdministrator],
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
