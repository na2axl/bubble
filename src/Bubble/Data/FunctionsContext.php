<?php

/**
 * Bubble - A PHP template engine
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @category  Library
 * @package   Bubble
 * @author    Axel Nana <ax.lnana@outlook.com>
 * @copyright 2018 Aliens Group, Inc.
 * @license   LGPL-3.0 <https://opensource.org/licenses/LGPL-3.0>
 * @version   GIT: 0.0.1
 * @link      http://bubble.na2axl.tk
 */

namespace Bubble\Data;

use Bubble\Bubble;


/**
 * Functions context
 *
 * Store all Bubble template's functions
 * as methods.
 *
 * @category Data
 * @package  Bubble
 * @author   Axel Nana <ax.lnana@outlook.com>
 * @license  LGPL-3.0 <https://opensource.org/licenses/LGPL-3.0>
 * @link     http://bubble.na2axl.tk/docs/api/Bubble/Data/FunctionsContext
 */
class FunctionsContext
{
    /**
     * Changes a string to uppercase
     *
     * @param string $var The string to change
     *
     * @return string
     */
    public function upper(string $var)
    {
        $config = Bubble::getConfiguration();

        if (MBSTRING_AVAILABLE) {
            return mb_strtoupper($var, $config->getEncoding());
        } else {
            return strtoupper($var);
        }
    }

    /**
     * Changes a string to lowercase
     *
     * @param string $var The string to change
     *
     * @return string
     */
    public function lower(string $var)
    {
        $config = Bubble::getConfiguration();

        if (MBSTRING_AVAILABLE) {
            return mb_strtolower($var, $config->getEncoding());
        } else {
            return strtolower($var);
        }
    }

    /**
     * Changes a string to uppercase
     *
     * @param string $var The string to change
     *
     * @return string
     */
    public function capitalize(string $var)
    {
        return ucfirst($var);
    }

    /**
     * Insert space (or optionally a given string)
     * between all characters of the string.
     *
     * @param string $val   The string to spacify
     * @param string $space The string to inject
     *
     * @return string
     */
    public function spacify(string $var, string $space = " ")
    {
        return implode($space, str_split($var));
    }

    /**
     * Replaces multiple spaces, new lines and tabulations
     * by a space (or optionally a given string).
     *
     * @param string $var   The string to strip
     * @param string $space The string to inject
     *
     * @return string
     */
    public function strip(string $var, string $space = " ")
    {
        return preg_replace("#( +|\\t+|\\n+|\\r)#", $space, $var);
    }

    /**
     * Truncates a string to the given length.
     *
     * @param string  $var         The string to truncate.
     * @param integer $length      The length.
     * @param string  $trunk       The string to insert at the end.
     * @param boolean $trunkWord   Define if we break words (false) or not (true).
     * @param boolean $trunkMiddle Define if we truncate at the middle of the string (true) or not (false).
     *
     * @return string
     */
    public function truncate(string $var, int $length = 80, string $trunk = "...", bool $trunkWord = false, bool $trunkMiddle = false)
    {
        $var = html_entity_decode($var);

        if ($length === 0) {
            return "";
        }

        if (MBSTRING_AVAILABLE) {
            $config = Bubble::getConfiguration();

            if (isset($var[ $length ])) {
                $length -= min($length, mb_strlen($trunk, $config->getEncoding()));

                if ($trunkWord && !$trunkMiddle) {
                    $var = preg_replace("/\s+?(\S+)?$/", "", mb_substr($var, 0, $length + 1, $config->getEncoding()));
                }

                if (!$trunkMiddle) {
                    return mb_substr($var, 0, $length, $config->getEncoding()) . $trunk;
                }

                return mb_substr($var, 0, $length / 2, $config->getEncoding()) . $trunk . mb_substr($var, - $length / 2, $length, $config->getEncoding());
            }
        } else {
            if (isset($var[ $length ])) {
                $length -= min($length, strlen($trunk));

                if ($trunkWord && !$trunkMiddle) {
                    $var = preg_replace("/\s+?(\S+)?$/", "", substr($var, 0, $length + 1));
                }

                if (!$trunkMiddle) {
                    return substr($var, 0, $length) . $trunk;
                }

                return substr($var, 0, $length / 2) . $trunk . substr($var, - $length / 2);
            }
        }

        return $var;
    }
}
