<?php

return [
    'labels' => [
        'title' => '审批流程',
        'description' => '流程引擎定义',
        'records' => '审批流程',
    ],
    'fields' => [
        'name' => '名称',
        'description' => '描述',
        'role' => [
            'name' => '角色'
        ],
        'approval_id' => '审批',
        'role_id' => '角色',
        'user_id' => '用户',
        'department_user_id' => '上级',
        'user' => [
            'name' => '用户'
        ]
    ],
];
