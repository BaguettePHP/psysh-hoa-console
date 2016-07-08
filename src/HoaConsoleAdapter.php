<?php

namespace zonuexe\Psy\Readline;

use Hoa\Console\Readline\Readline as HoaReadline;
use Psy\Exception\BreakException;

/**
 * Hoa\Console Readline implementation.
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 USAMI Kenta
 * @license   https://www.mozilla.org/en-US/MPL/2.0/ MPL-2.0
 */
class HoaConsoleAdapter implements Readline
{
    /** @var HoaReadline */
    private $hoaReadline;

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return class_exists('\Hoa\Console\Console', true);
    }

    public function __construct()
    {
        $this->hoaReadline = new HoaReadline();
    }

    /**
     * {@inheritdoc}
     */
    public function addHistory($line)
    {
        $this->hoaReadline->addHistory($line);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function clearHistory()
    {
        $this->hoaReadline->clearHistory();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function listHistory()
    {
        $i = 0;
        $list = array();
        while (($item = $this->hoaReadline->getHistory($i++)) !== null) {
            $list[] = $item;
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function readHistory()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BreakException if user hits Ctrl+D
     *
     * @return string
     */
    public function readline($prompt = null)
    {
        return $this->hoaReadline->readLine($prompt);
    }

    /**
     * {@inheritdoc}
     */
    public function redisplay()
    {
        // noop
    }

    /**
     * {@inheritdoc}
     */
    public function writeHistory()
    {
        return true;
    }
}
