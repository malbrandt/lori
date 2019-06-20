<?php

namespace Malbrandt\Lori\Utils;


use Illuminate\Console\Events\CommandStarting;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Wrapper class for console input & output.
 * Could be used to improve tracing.
 *
 * @package Malbrandt\Lori\Utils
 * @author  Marek Malbrandt <marek.malbrandt@gmail.com>
 * @since   0.9.5
 * @see     \cli(), \cli_in(), \cli_out() global helper functions (aliases)
 */
class Console
{
    private $input;
    private $output;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @return \Symfony\Component\Console\Input\InputInterface
     */
    public function getInput(): InputInterface
    {
        return $this->input;
    }

    /**
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    public function getOutput(
    ): OutputInterface
    {
        return $this->output;
    }

    public static function capture(CommandStarting $event): self
    {
        return new self($event->input, $event->output);
    }
}
