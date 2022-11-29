<?php

if (!defined('CONST')) {
    define('CONST', 'CONST');

    define('LABEL_COMMUNITY', 'label-cate-community');
    define('LABEL_HR', 'label-cate-hr');
    define('LABEL_NOTIFICATION', 'label-cate-notification');

    // define Label menu
    define('MENU_MY_COMPANY', 'my-company');
    define('MENU_HR', 'hr-hub');
    define('MENU_COMMUNITY', 'community');
    define('MENU_LABEL', [
        MENU_MY_COMPANY => LABEL_NOTIFICATION,
        MENU_HR => LABEL_HR,
        MENU_COMMUNITY => LABEL_COMMUNITY
    ]);

    // LIMIT POST
    define('LIMIT_POST', 10);

    // Role user
    define('ADMIN', 1);
    define('NOT_ADMIN', 2);

    //Post pinned
    define('PIN', 1);
    define('NOT_PIN', 2);

    //Type post
    define('POST_NORMAL', 1);
    define('POST_BIRTH_DAY', 2);
    define('POST_ONBOARD', 3);
    define('POST_MARRIAGE', 4);

    //Status post
    define('ACTIVE', 1);
    define('DEACTIVE', 2);

    //Limit Post Pinned
    define('LIMIT_PINNED', 5);

    //Limit Post normal
    define('LIMIT_POST_NORMAL', 6);

    // Menu select type option
    define('LIFE_LDCV_MENU', 'life-ldcv');
    define('KNOWLEDGE_SHARING', 'knowledge-sharing');
    define('GALLERY', 'gallery');

    // Remove image upload
    define('REMOVE_IMAGE', 1);

    // Path upload file post, ckeditor
    define('PATH_UPLOAD_FILE', '/public/posts/');

    define('PATH_UPLOAD_FILE_CKEDITOR', '/public/ckeditor');
    define('PATH_LOAD_FILE_CKEDITOR', '/storage/ckeditor/');

    //Filter
    define('FILTER_ASC', 'ASC');
    define('FILTER_DESC', 'DESC');
}
