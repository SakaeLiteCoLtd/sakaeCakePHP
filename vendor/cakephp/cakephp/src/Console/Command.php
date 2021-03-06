<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.6.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Console;

use Cake\Console\Exception\ConsoleException;
use Cake\Console\Exception\StopException;
use Cake\Datasource\ModelAwareTrait;
use Cake\Log\LogTrait;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Utility\Inflector;
use InvalidArgumentException;
use RuntimeException;

/**
 * Base class for console commands.
 */
class Command
{
    use LocatorAwareTrait;
    use LogTrait;
    use ModelAwareTrait;

    /**
     * Default error code
     *
     * @var int
     */
    const CODE_ERROR = 1;

    /**
     * Default success code
     *
     * @var int
     */
    const CODE_SUCCESS = 0;

    /**
     * The name of this command.
     *
     * @var string
     */
    protected $name = 'cake unknown';

    /**
     * Constructor
     *
     * By default CakePHP will construct command objects when
     * building the CommandCollection for your application.
     */
    public function __construct()
    {
        $this->modelFactory('Table', function ($alias) {
            return $this->getTableLocator()->get($alias);
        });

        if (isset($this->modelClass)) {
            $this->loadModel();
        }
    }

    /**
     * Set the name this command uses in the collection.
     *
     * Generally invoked by the CommandCollection when the command is added.
     * Required to have at least one space in the name so that the root
     * command can be calculated.
     *
     * @param string $name The name the command uses in the collection.
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setName($name)
    {
        if (strpos($name, ' ') < 1) {
            throw new InvalidArgumentException(
                "The name '{$name}' is missing a space. Names should look like `cake routes`"
            );
        }
        $this->name = $name;

        return $this;
    }

    /**
     * Get the command name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the command name.
     *
     * Returns the command name based on class name.
     * For e.g. for a command with class name `UpdateTableCommand` the default
     * name returned would be `'update_table'`.
     *
     * @return string
     */
    public static function defaultName()
    {
        $pos = strrpos(static::class, '\\');
        /** @psalm-suppress PossiblyFalseOperand */
        $name = substr(static::class, $pos + 1, -7);
        $name = Inflector::underscore($name);

        return $name;
    }

    /**
     * Get the option parser.
     *
     * You can override buildOptionParser() to define your options & arguments.
     *
     * @return \Cake\Console\ConsoleOptionParser
     * @throws \RuntimeException When the parser is invalid
     */
    public function getOptionParser()
    {
        list($root, $name) = explode(' ', $this->name, 2);
        $parser = new ConsoleOptionParser($name);
        $parser->setRootName($root);

        $parser = $this->buildOptionParser($parser);
        if (!($parser instanceof ConsoleOptionParser)) {
            throw new RuntimeException(sprintf(
                "Invalid option parser returned from buildOptionParser(). Expected %s, got %s",
                ConsoleOptionParser::class,
                getTypeName($parser)
            ));
        }

        return $parser;
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    protected function buildOptionParser(ConsoleOptionParser $parser)
    {
        return $parser;
    }

    /**
     * Hook method invoked by CakePHP when a command is about to be executed.
     *
     * Override this method and implement expensive/important setup steps that
     * should not run on every command run. This method will be called *before*
     * the options and arguments are validated and processed.
     *
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * Run the command.
     *
     * @param array $argv Arguments from the CLI environment.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null Exit code or null for success.
     */
    public function run(array $argv, ConsoleIo $io)
    {
        $this->initialize();

        $parser = $this->getOptionParser();
        try {
            list($options, $arguments) = $parser->parse($argv);
            $args = new Arguments(
                $arguments,
                $options,
                $parser->argumentNames()
            );
        } catch (ConsoleException $e) {
            $io->err('Error: ' . $e->getMessage());

            return static::CODE_ERROR;
        }
        $this->setOutputLevel($args, $io);

        if ($args->getOption('help')) {
            $this->displayHelp($parser, $args, $io);

            return static::CODE_SUCCESS;
        }

        return $this->execute($args, $io);
    }

    /**
     * Output help content
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The option parser.
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return void
     */
    protected function displayHelp(ConsoleOptionParser $parser, Arguments $args, ConsoleIo $io)
    {
        $format = 'text';
        if ($args->getArgumentAt(0) === 'xml') {
            $format = 'xml';
            $io->setOutputAs(ConsoleOutput::RAW);
        }

        $io->out($parser->help(null, $format));
    }

    /**
     * Set the output level based on the Arguments.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return void
     */
    protected function setOutputLevel(Arguments $args, ConsoleIo $io)
    {
        $io->setLoggers(ConsoleIo::NORMAL);
        if ($args->getOption('quiet')) {
            $io->level(ConsoleIo::QUIET);
            $io->setLoggers(ConsoleIo::QUIET);
        }
        if ($args->getOption('verbose')) {
            $io->level(ConsoleIo::VERBOSE);
            $io->setLoggers(ConsoleIo::VERBOSE);
        }
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        return null;
    }

    /**
     * Halt the the current process with a StopException.
     *
     * @param int $code The exit code to use.
     * @throws \Cake\Console\Exception\StopException
     * @return void
     */
    public function abort($code = self::CODE_ERROR)
    {
        throw new StopException('Command aborted', $code);
    }

    /**
     * Execute another command with the provided set of arguments.
     *
     * @param string|\Cake\Console\Command $command The command class name or command instance.
     * @param array $args The arguments to invoke the command with.
     * @param \Cake\Console\ConsoleIo $io The ConsoleIo instance to use for the executed command.
     * @return int|null The exit code or null for success of the command.
     */
    public function executeCommand($command, array $args = [], ConsoleIo $io = null)
    {
        if (is_string($command)) {
            if (!class_exists($command)) {
                throw new InvalidArgumentException("Command class '{$command}' does not exist.");
            }
            $command = new $command();
        }
        if (!$command instanceof Command) {
            $commandType = getTypeName($command);
            throw new InvalidArgumentException(
                "Command '{$commandType}' is not a subclass of Cake\Console\Command."
            );
        }
        $io = $io ?: new ConsoleIo();

        try {
            return $command->run($args, $io);
        } catch (StopException $e) {
            return $e->getCode();
        }
    }
}
