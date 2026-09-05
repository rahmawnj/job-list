<?php

return [
    'steps' => array_values(array_filter(array_map(
        'trim',
        explode(',', env('MILESTONE_STEPS', 'send_resume,interview_1,interview_2,mcu,offering,joint')))
    )),
    'statuses' => array_values(array_filter(array_map(
        'trim',
        explode(',', env('MILESTONE_STATUSES', 'pending,active,completed')))
    )),
];