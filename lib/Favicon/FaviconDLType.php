<?php


namespace Favicon;


interface FaviconDLType
{
    /**
     * Retrieve remote favicon URL.
     */
    const HOTLINK_URL = 0;

    /**
     * Retrieve downloaded favicon path (requires cache).
     */
    const DL_FILE_PATH = 1;

    /**
     * Retrieve the image content as a binary string.
     */
    const RAW_IMAGE = 2;
}
