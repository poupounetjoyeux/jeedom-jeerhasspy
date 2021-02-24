<?php

require_once dirname(__FILE__) . '/../core/utils/jeerhasspy.constants.config.php';

function jeerhasspy_install()
{
    $sql = file_get_contents(dirname(__FILE__) . '/install.sql');
    DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
}

function jeerhasspy_update()
{
}

function jeerhasspy_remove()
{
    $sql = 'DROP TABLE JeerhasspySlot';
    DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

    $sql = 'DROP TABLE JeerhasspyAnswer';
    DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);

    $sql = "DELETE FROM `config` WHERE `key` LIKE '%" . jeerhasspy_id . "%'";
    DB::Prepare($sql, array(), DB::FETCH_TYPE_ROW);
}

?>
