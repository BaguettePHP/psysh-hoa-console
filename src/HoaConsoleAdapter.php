<?php

namespace zonuexe\Psy\Readline;

use Psy\Readline\Readline;
use Psy\Exception\BreakException;
use Hoa\Console\Console;
use Hoa\Console\Readline\Readline as HoaReadline;

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
    private $hoa_readline;

    /** @var \ReflectionProperty */
    private $reflection;

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return class_exists('\Hoa\Console\Console', true);
    }

    public function __construct()
    {
        $this->hoa_readline = new HoaReadline();
        $this->reflection = new \ReflectionProperty($this->hoa_readline, '_history');
    }

    /**
     * {@inheritdoc}
     */
    public function addHistory($line)
    {
        $this->hoa_readline->addHistory($line);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function clearHistory()
    {
        $this->hoa_readline->clearHistory();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function listHistory()
    {
        $this->reflection->setAccessible(true);
        $list = $this->reflection->getValue($this->hoa_readline);
        $this->reflection->setAccessible(false);

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
        return $this->hoa_readline->readLine($prompt);
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

    /**
     * Get a STDIN file handle.
     *
     * @throws BreakException if user hits Ctrl+D
     *
     * @return resource
     */
    private function getStdin()
    {
        return Console::getInput()->getStream()->getStream();
    }
}
