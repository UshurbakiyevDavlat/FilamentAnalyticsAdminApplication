<?php

#check ids of roles, they should be the same as in the database
use App\Enums\RoleIntEnum;

return [
    RoleIntEnum::SUPER_ADMIN->value => 'Super Admin',
    RoleIntEnum::ADMIN->value => 'Admin',
    RoleIntEnum::ANALYST->value => 'Analyst',
    RoleIntEnum::EDITOR->value => 'Editor',
    RoleIntEnum::READER->value => 'Reader',
];
