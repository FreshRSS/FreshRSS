<?php

// SPDX-FileCopyrightText: 2004-2023 Ryan Parman, Sam Sneddon, Ryan McCue
// SPDX-License-Identifier: BSD-3-Clause

declare(strict_types=1);

namespace SimplePie\Parse;

/**
 * Date Parser
 */
class Date
{
    /**
     * Input data
     *
     * @access protected
     * @var string
     */
    public $date;

    /**
     * List of days, calendar day name => ordinal day number in the week
     *
     * @access protected
     * @var array<string, int<1,7>>
     */
    public $day = [
        // English
        'mon' => 1,
        'monday' => 1,
        'tue' => 2,
        'tuesday' => 2,
        'wed' => 3,
        'wednesday' => 3,
        'thu' => 4,
        'thursday' => 4,
        'fri' => 5,
        'friday' => 5,
        'sat' => 6,
        'saturday' => 6,
        'sun' => 7,
        'sunday' => 7,
        // Dutch
        'maandag' => 1,
        'dinsdag' => 2,
        'woensdag' => 3,
        'donderdag' => 4,
        'vrijdag' => 5,
        'zaterdag' => 6,
        'zondag' => 7,
        // French
        'lundi' => 1,
        'mardi' => 2,
        'mercredi' => 3,
        'jeudi' => 4,
        'vendredi' => 5,
        'samedi' => 6,
        'dimanche' => 7,
        // German
        'montag' => 1,
        'mo' => 1,
        'dienstag' => 2,
        'di' => 2,
        'mittwoch' => 3,
        'mi' => 3,
        'donnerstag' => 4,
        'do' => 4,
        'freitag' => 5,
        'fr' => 5,
        'samstag' => 6,
        'sa' => 6,
        'sonnabend' => 6,
        // AFAIK no short form for sonnabend
        'so' => 7,
        'sonntag' => 7,
        // Italian
        'lunedì' => 1,
        'martedì' => 2,
        'mercoledì' => 3,
        'giovedì' => 4,
        'venerdì' => 5,
        'sabato' => 6,
        'domenica' => 7,
        // Spanish
        'lunes' => 1,
        'martes' => 2,
        'miércoles' => 3,
        'jueves' => 4,
        'viernes' => 5,
        'sábado' => 6,
        'domingo' => 7,
        // Finnish
        'maanantai' => 1,
        'tiistai' => 2,
        'keskiviikko' => 3,
        'torstai' => 4,
        'perjantai' => 5,
        'lauantai' => 6,
        'sunnuntai' => 7,
        // Hungarian
        'hétfő' => 1,
        'kedd' => 2,
        'szerda' => 3,
        'csütörtok' => 4,
        'péntek' => 5,
        'szombat' => 6,
        'vasárnap' => 7,
        // Greek
        'Δευ' => 1,
        'Τρι' => 2,
        'Τετ' => 3,
        'Πεμ' => 4,
        'Παρ' => 5,
        'Σαβ' => 6,
        'Κυρ' => 7,
        // Russian
        'Пн.' => 1,
        'Вт.' => 2,
        'Ср.' => 3,
        'Чт.' => 4,
        'Пт.' => 5,
        'Сб.' => 6,
        'Вс.' => 7,
    ];

    /**
     * List of months, calendar month name => calendar month number
     *
     * @access protected
     * @var array<string, int<1,12>>
     */
    public $month = [
        // English
        'jan' => 1,
        'january' => 1,
        'feb' => 2,
        'february' => 2,
        'mar' => 3,
        'march' => 3,
        'apr' => 4,
        'april' => 4,
        'may' => 5,
        // No long form of May
        'jun' => 6,
        'june' => 6,
        'jul' => 7,
        'july' => 7,
        'aug' => 8,
        'august' => 8,
        'sep' => 9,
        'september' => 9,
        'oct' => 10,
        'october' => 10,
        'nov' => 11,
        'november' => 11,
        'dec' => 12,
        'december' => 12,
        // Dutch
        'januari' => 1,
        'februari' => 2,
        'maart' => 3,
        // 'april' => 4,
        'mei' => 5,
        'juni' => 6,
        'juli' => 7,
        'augustus' => 8,
        // 'september' => 9,
        'oktober' => 10,
        // 'november' => 11,
        // 'december' => 12,
        // French
        'janvier' => 1,
        'février' => 2,
        'mars' => 3,
        'avril' => 4,
        'mai' => 5,
        'juin' => 6,
        'juillet' => 7,
        'août' => 8,
        'septembre' => 9,
        'octobre' => 10,
        'novembre' => 11,
        'décembre' => 12,
        // German
        'januar' => 1,
        // 'jan' => 1,
        'februar' => 2,
        // 'feb' => 2,
        'märz' => 3,
        'mär' => 3,
        // 'april' => 4,
        // 'apr' => 4,
        // 'mai' => 5, // no short form for may
        // 'juni' => 6,
        // 'jun' => 6,
        // 'juli' => 7,
        // 'jul' => 7,
        // 'august' => 8,
        // 'aug' => 8,
        // 'september' => 9,
        // 'sep' => 9,
        // 'oktober' => 10,
        'okt' => 10,
        // 'november' => 11,
        // 'nov' => 11,
        'dezember' => 12,
        'dez' => 12,
        // Italian
        'gennaio' => 1,
        'febbraio' => 2,
        'marzo' => 3,
        'aprile' => 4,
        'maggio' => 5,
        'giugno' => 6,
        'luglio' => 7,
        'agosto' => 8,
        'settembre' => 9,
        'ottobre' => 10,
        // 'novembre' => 11,
        'dicembre' => 12,
        // Spanish
        'enero' => 1,
        'febrero' => 2,
        // 'marzo' => 3,
        'abril' => 4,
        'mayo' => 5,
        'junio' => 6,
        'julio' => 7,
        // 'agosto' => 8,
        'septiembre' => 9,
        'setiembre' => 9,
        'octubre' => 10,
        'noviembre' => 11,
        'diciembre' => 12,
        // Finnish
        'tammikuu' => 1,
        'helmikuu' => 2,
        'maaliskuu' => 3,
        'huhtikuu' => 4,
        'toukokuu' => 5,
        'kesäkuu' => 6,
        'heinäkuu' => 7,
        'elokuu' => 8,
        'suuskuu' => 9,
        'lokakuu' => 10,
        'marras' => 11,
        'joulukuu' => 12,
        // Hungarian
        'január' => 1,
        'február' => 2,
        'március' => 3,
        'április' => 4,
        'május' => 5,
        'június' => 6,
        'július' => 7,
        'augusztus' => 8,
        'szeptember' => 9,
        'október' => 10,
        // 'november' => 11,
        // 'december' => 12,
        // Greek
        'Ιαν' => 1,
        'Φεβ' => 2,
        'Μάώ' => 3,
        'Μαώ' => 3,
        'Απρ' => 4,
        'Μάι' => 5,
        'Μαϊ' => 5,
        'Μαι' => 5,
        'Ιούν' => 6,
        'Ιον' => 6,
        'Ιούλ' => 7,
        'Ιολ' => 7,
        'Αύγ' => 8,
        'Αυγ' => 8,
        'Σεπ' => 9,
        'Οκτ' => 10,
        'Νοέ' => 11,
        'Δεκ' => 12,
        // Russian
        'Янв' => 1,
        'января' => 1,
        'Фев' => 2,
        'февраля' => 2,
        'Мар' => 3,
        'марта' => 3,
        'Апр' => 4,
        'апреля' => 4,
        'Май' => 5,
        'мая' => 5,
        'Июн' => 6,
        'июня' => 6,
        'Июл' => 7,
        'июля' => 7,
        'Авг' => 8,
        'августа' => 8,
        'Сен' => 9,
        'сентября' => 9,
        'Окт' => 10,
        'октября' => 10,
        'Ноя' => 11,
        'ноября' => 11,
        'Дек' => 12,
        'декабря' => 12,

    ];

    /**
     * List of timezones, abbreviation => offset from UTC
     *
     * @access protected
     * @var array<string, int>
     */
    public $timezone = [
        'ACDT' => 37800,
        'ACIT' => 28800,
        'ACST' => 34200,
        'ACT' => -18000,
        'ACWDT' => 35100,
        'ACWST' => 31500,
        'AEDT' => 39600,
        'AEST' => 36000,
        'AFT' => 16200,
        'AKDT' => -28800,
        'AKST' => -32400,
        'AMDT' => 18000,
        'AMT' => -14400,
        'ANAST' => 46800,
        'ANAT' => 43200,
        'ART' => -10800,
        'AZOST' => -3600,
        'AZST' => 18000,
        'AZT' => 14400,
        'BIOT' => 21600,
        'BIT' => -43200,
        'BOT' => -14400,
        'BRST' => -7200,
        'BRT' => -10800,
        'BST' => 3600,
        'BTT' => 21600,
        'CAST' => 18000,
        'CAT' => 7200,
        'CCT' => 23400,
        'CDT' => -18000,
        'CEDT' => 7200,
        'CEST' => 7200,
        'CET' => 3600,
        'CGST' => -7200,
        'CGT' => -10800,
        'CHADT' => 49500,
        'CHAST' => 45900,
        'CIST' => -28800,
        'CKT' => -36000,
        'CLDT' => -10800,
        'CLST' => -14400,
        'COT' => -18000,
        'CST' => -21600,
        'CVT' => -3600,
        'CXT' => 25200,
        'DAVT' => 25200,
        'DTAT' => 36000,
        'EADT' => -18000,
        'EAST' => -21600,
        'EAT' => 10800,
        'ECT' => -18000,
        'EDT' => -14400,
        'EEST' => 10800,
        'EET' => 7200,
        'EGT' => -3600,
        'EKST' => 21600,
        'EST' => -18000,
        'FJT' => 43200,
        'FKDT' => -10800,
        'FKST' => -14400,
        'FNT' => -7200,
        'GALT' => -21600,
        'GEDT' => 14400,
        'GEST' => 10800,
        'GFT' => -10800,
        'GILT' => 43200,
        'GIT' => -32400,
        'GST' => 14400,
        // 'GST' => -7200,
        'GYT' => -14400,
        'HAA' => -10800,
        'HAC' => -18000,
        'HADT' => -32400,
        'HAE' => -14400,
        'HAP' => -25200,
        'HAR' => -21600,
        'HAST' => -36000,
        'HAT' => -9000,
        'HAY' => -28800,
        'HKST' => 28800,
        'HMT' => 18000,
        'HNA' => -14400,
        'HNC' => -21600,
        'HNE' => -18000,
        'HNP' => -28800,
        'HNR' => -25200,
        'HNT' => -12600,
        'HNY' => -32400,
        'IRDT' => 16200,
        'IRKST' => 32400,
        'IRKT' => 28800,
        'IRST' => 12600,
        'JFDT' => -10800,
        'JFST' => -14400,
        'JST' => 32400,
        'KGST' => 21600,
        'KGT' => 18000,
        'KOST' => 39600,
        'KOVST' => 28800,
        'KOVT' => 25200,
        'KRAST' => 28800,
        'KRAT' => 25200,
        'KST' => 32400,
        'LHDT' => 39600,
        'LHST' => 37800,
        'LINT' => 50400,
        'LKT' => 21600,
        'MAGST' => 43200,
        'MAGT' => 39600,
        'MAWT' => 21600,
        'MDT' => -21600,
        'MESZ' => 7200,
        'MEZ' => 3600,
        'MHT' => 43200,
        'MIT' => -34200,
        'MNST' => 32400,
        'MSDT' => 14400,
        'MSST' => 10800,
        'MST' => -25200,
        'MUT' => 14400,
        'MVT' => 18000,
        'MYT' => 28800,
        'NCT' => 39600,
        'NDT' => -9000,
        'NFT' => 41400,
        'NMIT' => 36000,
        'NOVST' => 25200,
        'NOVT' => 21600,
        'NPT' => 20700,
        'NRT' => 43200,
        'NST' => -12600,
        'NUT' => -39600,
        'NZDT' => 46800,
        'NZST' => 43200,
        'OMSST' => 25200,
        'OMST' => 21600,
        'PDT' => -25200,
        'PET' => -18000,
        'PETST' => 46800,
        'PETT' => 43200,
        'PGT' => 36000,
        'PHOT' => 46800,
        'PHT' => 28800,
        'PKT' => 18000,
        'PMDT' => -7200,
        'PMST' => -10800,
        'PONT' => 39600,
        'PST' => -28800,
        'PWT' => 32400,
        'PYST' => -10800,
        'PYT' => -14400,
        'RET' => 14400,
        'ROTT' => -10800,
        'SAMST' => 18000,
        'SAMT' => 14400,
        'SAST' => 7200,
        'SBT' => 39600,
        'SCDT' => 46800,
        'SCST' => 43200,
        'SCT' => 14400,
        'SEST' => 3600,
        'SGT' => 28800,
        'SIT' => 28800,
        'SRT' => -10800,
        'SST' => -39600,
        'SYST' => 10800,
        'SYT' => 7200,
        'TFT' => 18000,
        'THAT' => -36000,
        'TJT' => 18000,
        'TKT' => -36000,
        'TMT' => 18000,
        'TOT' => 46800,
        'TPT' => 32400,
        'TRUT' => 36000,
        'TVT' => 43200,
        'TWT' => 28800,
        'UYST' => -7200,
        'UYT' => -10800,
        'UZT' => 18000,
        'VET' => -14400,
        'VLAST' => 39600,
        'VLAT' => 36000,
        'VOST' => 21600,
        'VUT' => 39600,
        'WAST' => 7200,
        'WAT' => 3600,
        'WDT' => 32400,
        'WEST' => 3600,
        'WFT' => 43200,
        'WIB' => 25200,
        'WIT' => 32400,
        'WITA' => 28800,
        'WKST' => 18000,
        'WST' => 28800,
        'YAKST' => 36000,
        'YAKT' => 32400,
        'YAPT' => 36000,
        'YEKST' => 21600,
        'YEKT' => 18000,
    ];

    /**
     * Cached PCRE for Date::$day
     *
     * @access protected
     * @var string
     */
    public $day_pcre;

    /**
     * Cached PCRE for Date::$month
     *
     * @access protected
     * @var string
     */
    public $month_pcre;

    /**
     * Array of user-added callback methods
     *
     * @access private
     * @var array<string>
     */
    public $built_in = [];

    /**
     * Array of user-added callback methods
     *
     * @access private
     * @var array<callable(string): string|false>
     */
    public $user = [];

    /**
     * Create new Date object, and set self::day_pcre,
     * self::month_pcre, and self::built_in
     *
     * @access private
     */
    public function __construct()
    {
        $this->day_pcre = '(' . implode('|', array_keys($this->day)) . ')';
        $this->month_pcre = '(' . implode('|', array_keys($this->month)) . ')';

        static $cache;
        if (!isset($cache[get_class($this)])) {
            $all_methods = get_class_methods($this);

            foreach ($all_methods as $method) {
                if (strtolower(substr($method, 0, 5)) === 'date_') {
                    $cache[get_class($this)][] = $method;
                }
            }
        }

        foreach ($cache[get_class($this)] as $method) {
            $this->built_in[] = $method;
        }
    }

    /**
     * Get the object
     *
     * @access public
     * @return Date
     */
    public static function get()
    {
        static $object;
        if (!$object) {
            $object = new Date();
        }
        return $object;
    }

    /**
     * Parse a date
     *
     * @final
     * @access public
     * @param string $date Date to parse
     * @return int|false Timestamp corresponding to date string, or false on failure
     */
    public function parse(string $date)
    {
        foreach ($this->user as $method) {
            if (($returned = call_user_func($method, $date)) !== false) {
                return $returned;
            }
        }

        foreach ($this->built_in as $method) {
            if (($returned = call_user_func([$this, $method], $date)) !== false) {
                return $returned;
            }
        }

        return false;
    }

    /**
     * Add a callback method to parse a date
     *
     * @final
     * @access public
     * @param callable $callback
     * @return void
     */
    public function add_callback(callable $callback)
    {
        $this->user[] = $callback;
    }

    /**
     * Parse a superset of W3C-DTF (allows hyphens and colons to be omitted, as
     * well as allowing any of upper or lower case "T", horizontal tabs, or
     * spaces to be used as the time separator (including more than one))
     *
     * @access protected
     * @param string $date
     * @return int|false Timestamp
     */
    public function date_w3cdtf(string $date)
    {
        $pcre = <<<'PCRE'
            /
            ^
            (?P<year>[0-9]{4})
            (?:
                -?
                (?P<month>[0-9]{2})
                (?:
                    -?
                    (?P<day>[0-9]{2})
                    (?:
                        [Tt\x09\x20]+
                        (?P<hour>[0-9]{2})
                        (?:
                            :?
                            (?P<minute>[0-9]{2})
                            (?:
                                :?
                                (?P<second>[0-9]{2})
                                (?:
                                    .
                                    (?P<second_fraction>[0-9]*)
                                )?
                            )?
                        )?
                        (?:
                            (?P<zulu>Z)
                            |   (?P<tz_sign>[+\-])
                                (?P<tz_hour>[0-9]{1,2})
                                :?
                                (?P<tz_minute>[0-9]{1,2})
                        )
                    )?
                )?
            )?
            $
            /x
PCRE;
        if (preg_match($pcre, $date, $match)) {
            // Fill in empty matches and convert to proper types.
            $year = (int) $match['year'];
            $month = isset($match['month']) ? (int) $match['month'] : 1;
            $day = isset($match['day']) ? (int) $match['day'] : 1;
            $hour = isset($match['hour']) ? (int) $match['hour'] : 0;
            $minute = isset($match['minute']) ? (int) $match['minute'] : 0;
            $second = isset($match['second']) ? (int) $match['second'] : 0;
            $second_fraction = isset($match['second_fraction']) ? ((int) $match['second_fraction']) / (10 ** strlen($match['second_fraction'])) : 0;
            $tz_sign = ($match['tz_sign'] ?? '') === '-' ? -1 : 1;
            $tz_hour = isset($match['tz_hour']) ? (int) $match['tz_hour'] : 0;
            $tz_minute = isset($match['tz_minute']) ? (int) $match['tz_minute'] : 0;

            // Numeric timezone
            $timezone = $tz_hour * 3600;
            $timezone += $tz_minute * 60;
            $timezone *= $tz_sign;

            // Convert the number of seconds to an integer, taking decimals into account
            $second = (int) round($second + $second_fraction);

            return gmmktime($hour, $minute, $second, $month, $day, $year) - $timezone;
        }

        return false;
    }

    /**
     * Remove RFC822 comments
     *
     * @access protected
     * @param string $string Data to strip comments from
     * @return string Comment stripped string
     */
    public function remove_rfc2822_comments(string $string)
    {
        $position = 0;
        $length = strlen($string);
        $depth = 0;

        $output = '';

        while ($position < $length && ($pos = strpos($string, '(', $position)) !== false) {
            $output .= substr($string, $position, $pos - $position);
            $position = $pos + 1;
            if ($pos === 0 || $string[$pos - 1] !== '\\') {
                $depth++;
                while ($depth && $position < $length) {
                    $position += strcspn($string, '()', $position);
                    if ($string[$position - 1] === '\\') {
                        $position++;
                        continue;
                    } elseif (isset($string[$position])) {
                        switch ($string[$position]) {
                            case '(':
                                $depth++;
                                break;

                            case ')':
                                $depth--;
                                break;
                        }
                        $position++;
                    } else {
                        break;
                    }
                }
            } else {
                $output .= '(';
            }
        }
        $output .= substr($string, $position);

        return $output;
    }

    /**
     * Parse RFC2822's date format
     *
     * @access protected
     * @param string $date
     * @return int|false Timestamp
     */
    public function date_rfc2822(string $date)
    {
        static $pcre;
        if (!$pcre) {
            $wsp = '[\x09\x20]';
            $fws = '(?:' . $wsp . '+|' . $wsp . '*(?:\x0D\x0A' . $wsp . '+)+)';
            $optional_fws = $fws . '?';
            $day_name = $this->day_pcre;
            $month = $this->month_pcre;
            $day = '([0-9]{1,2})';
            $hour = $minute = $second = '([0-9]{2})';
            $year = '([0-9]{2,4})';
            $num_zone = '([+\-])([0-9]{2})([0-9]{2})';
            $character_zone = '([A-Z]{1,5})';
            $zone = '(?:' . $num_zone . '|' . $character_zone . ')';
            $pcre = '/(?:' . $optional_fws . $day_name . $optional_fws . ',)?' . $optional_fws . $day . $fws . $month . $fws . $year . $fws . $hour . $optional_fws . ':' . $optional_fws . $minute . '(?:' . $optional_fws . ':' . $optional_fws . $second . ')?' . $fws . $zone . '/i';
        }
        if (preg_match($pcre, $this->remove_rfc2822_comments($date), $match)) {
            /*
            Capturing subpatterns:
            1: Day name
            2: Day
            3: Month
            4: Year
            5: Hour
            6: Minute
            7: Second
            8: Timezone ±
            9: Timezone hours
            10: Timezone minutes
            11: Alphabetic timezone
            */

            $day = (int) $match[2];
            // Find the month number
            $month = $this->month[strtolower($match[3])];
            $year = (int) $match[4];
            $hour = (int) $match[5];
            $minute = (int) $match[6];
            // Second is optional, if it is empty set it to zero
            $second = (int) $match[7];

            $tz_sign = $match[8];
            $tz_hour = (int) $match[9];
            $tz_minute = (int) $match[10];
            $tz_code = isset($match[11]) ? strtoupper($match[11]) : '';

            // Numeric timezone
            if ($tz_sign !== '') {
                $timezone = $tz_hour * 3600;
                $timezone += $tz_minute * 60;
                if ($tz_sign === '-') {
                    $timezone = 0 - $timezone;
                }
            }
            // Character timezone
            elseif (isset($this->timezone[$tz_code])) {
                $timezone = $this->timezone[$tz_code];
            }
            // Assume everything else to be -0000
            else {
                $timezone = 0;
            }

            // Deal with 2/3 digit years
            if ($year < 50) {
                $year += 2000;
            } elseif ($year < 1000) {
                $year += 1900;
            }

            return gmmktime($hour, $minute, $second, $month, $day, $year) - $timezone;
        }

        return false;
    }

    /**
     * Parse RFC850's date format
     *
     * @access protected
     * @param string $date
     * @return int|false Timestamp
     */
    public function date_rfc850(string $date)
    {
        static $pcre;
        if (!$pcre) {
            $space = '[\x09\x20]+';
            $day_name = $this->day_pcre;
            $month = $this->month_pcre;
            $day = '([0-9]{1,2})';
            $year = $hour = $minute = $second = '([0-9]{2})';
            $zone = '([A-Z]{1,5})';
            $pcre = '/^' . $day_name . ',' . $space . $day . '-' . $month . '-' . $year . $space . $hour . ':' . $minute . ':' . $second . $space . $zone . '$/i';
        }
        if (preg_match($pcre, $date, $match)) {
            /*
            Capturing subpatterns:
            1: Day name
            2: Day
            3: Month
            4: Year
            5: Hour
            6: Minute
            7: Second
            8: Timezone
            */

            $day = (int) $match[2];
            // Month
            $month = $this->month[strtolower($match[3])];
            $year = (int) $match[4];
            $hour = (int) $match[5];
            $minute = (int) $match[6];
            // Second is optional, if it is empty set it to zero
            $second = (int) $match[7];

            $tz_code = strtoupper($match[8]);

            // Character timezone
            if (isset($this->timezone[$tz_code])) {
                $timezone = $this->timezone[$tz_code];
            }
            // Assume everything else to be -0000
            else {
                $timezone = 0;
            }

            // Deal with 2 digit year
            if ($year < 50) {
                $year += 2000;
            } else {
                $year += 1900;
            }

            return gmmktime($hour, $minute, $second, $month, $day, $year) - $timezone;
        }

        return false;
    }

    /**
     * Parse C99's asctime()'s date format
     *
     * @access protected
     * @param string $date
     * @return int|false Timestamp
     */
    public function date_asctime(string $date)
    {
        static $pcre;
        if (!$pcre) {
            $space = '[\x09\x20]+';
            $wday_name = $this->day_pcre;
            $mon_name = $this->month_pcre;
            $day = '([0-9]{1,2})';
            $hour = $sec = $min = '([0-9]{2})';
            $year = '([0-9]{4})';
            $terminator = '\x0A?\x00?';
            $pcre = '/^' . $wday_name . $space . $mon_name . $space . $day . $space . $hour . ':' . $min . ':' . $sec . $space . $year . $terminator . '$/i';
        }
        if (preg_match($pcre, $date, $match)) {
            /*
            Capturing subpatterns:
            1: Day name
            2: Month
            3: Day
            4: Hour
            5: Minute
            6: Second
            7: Year
            */

            $month = $this->month[strtolower($match[2])];
            return gmmktime((int) $match[4], (int) $match[5], (int) $match[6], $month, (int) $match[3], (int) $match[7]);
        }

        return false;
    }

    /**
     * Parse dates using strtotime()
     *
     * @access protected
     * @param string $date
     * @return int|false Timestamp
     */
    public function date_strtotime(string $date)
    {
        $strtotime = strtotime($date);
        if ($strtotime === -1 || $strtotime === false) {
            return false;
        }

        return $strtotime;
    }
}

class_alias('SimplePie\Parse\Date', 'SimplePie_Parse_Date');
