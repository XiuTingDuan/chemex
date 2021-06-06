<?php


namespace App\Aspect;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class DcatMethodPermission
{
    private string $permission;

    public function __construct(string $permission)
    {
        $this->permission = $permission;
    }

    public function getPermissions(): string
    {
        return $this->permission;
    }
}
