<?php

#check ids of roles, they should be the same as in the database
use App\Enums\RoleIntEnum;

return [
    RoleIntEnum::SUPER_ADMIN->value => 'Супер Админ',
    RoleIntEnum::ADMIN->value => 'Администратор',
    RoleIntEnum::ANALYST->value => 'Аналитик',
    RoleIntEnum::EDITOR->value => 'Редактор',
    RoleIntEnum::READER->value => 'Читатель',
];
