<?php
/**
 * JBZoo Application
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    Application
 * @license    GPL-2.0
 * @copyright  Copyright (C) JBZoo.com, All rights reserved.
 * @link       https://github.com/JBZoo/JBZoo
 * @author     Denis Smetannikov <denis@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class JBDebugHelper
 */
class JBDebugHelper extends AppHelper
{
    /**
     * JBDump instance
     * @var JBDump|JProfiler
     */
    protected static $_jbdump = null;

    /**
     * JBDump context
     * @var string
     */
    protected $_jbdumpContext = 'jbzoo';

    /**
     * JBDump params
     * @var array
     */
    protected $_jbdumpParams = array();

    /**
     * @param Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);
        return; // for debug only

        if (self::$_jbdump === null) {
            // Joomla standard profiler
            if (JDEBUG) {
                self::$_jbdump = JProfiler::getInstance('Application');
            }

            // jbdump plugin
            if (class_exists('jbdump')) {
                self::$_jbdump = JBDump::i($this->_jbdumpParams);
            }
        }
    }

    /**
     * Set profiler mark
     * @param string $name
     */
    public function mark($name = '')
    {
        if (self::$_jbdump !== null && method_exists(self::$_jbdump, 'mark')) {
            //self::$_jbdump->mark($name);
        }
    }

    /**
     * Dump sql queries
     * @param $select
     */
    public function sql($select)
    {
        if (self::$_jbdump !== null && method_exists(self::$_jbdump, 'sql')) {
            //self::$_jbdump->sql((string)$select, 'jbdebug::sql');
        }
    }

    /**
     * @param $message
     */
    public function log($message)
    {
        if (self::$_jbdump !== null && method_exists(self::$_jbdump, 'log')) {
            self::$_jbdump->log($message, 'jbdebug::log');
        }
    }

    /**
     * @param array  $array
     * @param string $arrayName
     */
    public function logArray($array, $arrayName = 'data')
    {
        if (self::$_jbdump !== null && method_exists(self::$_jbdump, 'phpArray')) {
            $arrayString = self::$_jbdump->phpArray($array, $arrayName, true);
            $this->log($arrayString);
        }
    }

}
