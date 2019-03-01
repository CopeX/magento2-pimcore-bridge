<?php

namespace Divante\PimcoreIntegration\Console\Command;

use Magento\Framework\App\State;
use Magento\Framework\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 * @package CopeX\Import\Console\Command
 *
 */
abstract class AbstractCommand extends Command
{

    /**
     * @var State
     */
    private $state;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * AbstractCommand constructor.
     * @param State    $state
     * @param Registry $registry
     * @param string     $name
     */

    public function __construct(
        State $state,
        Registry $registry,
        string $name = null
    ) {
        parent::__construct($name);
        $this->state = $state;
        $this->registry = $registry;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        } catch (\Exception $ex) {
            // fail gracefully
        }

        $this->registry->register('isSecureArea', true);

        $start = $this->getCurrentMs();

        $output->writeln('<info>Initialization: '.$this->getDescription().'</info>');
        $output->writeln(sprintf('<info>Started at %s</info>', (new \DateTime())->format('Y-m-d H:i:s')));
        $output->writeln('Processing...');

        $this->process();

        $end = $this->getCurrentMs();

        $output->writeln(sprintf('<info>Finished at %s</info>', (new \DateTime())->format('Y-m-d H:i:s')));
        $output->writeln(sprintf('<info>Total execution time %sms</info>', $end - $start));

        return 0;
    }

    /**
     *
     * @return float|int
     */
    protected function getCurrentMs()
    {
        $mt = explode(' ', microtime());

        return ((int) $mt[1]) * 1000 + ((int) round($mt[0] * 1000));
    }

    abstract public function process();

}