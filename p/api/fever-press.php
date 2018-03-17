<?php
/**
 * Fever API for FreshRSS
 * Version 0.1
 * Author: Kevin Papst / https://github.com/kevinpapst
 *
 * API endpoint for the Press Android client (only tested with 1.5.4)
 */

function createFeverApiInstance()
{
    if (!class_exists('FeverAPI_PressClient', false))
    {
        class FeverAPI_PressClient extends FeverAPI
        {
            protected function getDaoForEntries()
            {
                return new FeverAPI_EntryDAO_PressClient();
            }
            protected function setGroupAsRead($id, $before)
            {
                $before = $this->convertBeforeToId($before);
                $dao = $this->getDaoForEntries();
                if ($id === 0) {
                    $dao = $this->getDaoForEntries();
                    $counts = $dao->countFever();
                    $dao->markReadEntries($counts['max']);
                } else {
                    $dao->markReadCat($id, $before);
                }
            }
        }

        class FeverAPI_EntryDAO_PressClient extends FeverAPI_EntryDAO
        {
            protected function getSelectLimit($max_id, $since_id)
            {
                if (!empty($entry_ids)) {
                    return ' LIMIT 50';
                } else if (!empty($max_id)) {
                    return ' LIMIT 50';
                }

                if ($since_id < 0) {
                    $since_id = 0;
                }

                return ' LIMIT '.intval($since_id).', 50';
            }
        }

    }
    return new FeverAPI_PressClient();
}

include_once __DIR__ . '/fever.php';
