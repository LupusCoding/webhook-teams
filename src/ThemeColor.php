<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams;

/**
 * Class ThemeColor
 * @package LupusCoding\Webhooks\Teams
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 *
 * This class holds some predefined colors. You can either
 * use these colors by writing for example ThemeColor::INFO
 * or you can write just any color in hex format.
 */
class ThemeColor
{
    const DEBUG = '#D0CCD0';
    const INFO = '#004FFF';
    const WARNING = '#FF7733';
    const ERROR = '#F85A3E';
    const CRITICAL = '#CA054D';
    const EMERGANCY = '#960200';
    const SUCCESS = '#60992D';
    const FAIL = '#B08830';
}