<?php

namespace zonuexe\Psy\Readline;

use Hoa\Console\Cursor;
use Hoa\Console\Readline\Readline as HoaReadline;
use Psy\Exception\BreakException;

/**
 * Hoa\Console Readline implementation.
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 USAMI Kenta
 * @license   https://www.mozilla.org/en-US/MPL/2.0/ MPL-2.0
 */
class HoaConsoleAdapter implements \Psy\Readline\Readline
{
    /** @var HoaReadline */
    private $hoaReadline;

    /** @var string */
    private $lastPrompt;

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
        $this->hoaReadline->addMapping('\C-l', array($this, 'redisplay'));
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
        $this->lastPrompt = $prompt;

        return $this->hoaReadline->readLine($prompt);
    }

    /**
     * {@inheritdoc}
     */
    public function redisplay()
    {
        $current_line = $this->hoaReadline->getLine();
        Cursor::clear('all');
        //Cursor::moveTo(0, 0);
        echo $this->lastPrompt, $current_line;
        Cursor::moveTo(mb_strlen($this->lastPrompt) + mb_strlen($current_line) + 1, 0);
    }

    /**
     * {@inheritdoc}
     */
    public function writeHistory()
    {
        return true;
    }
}
