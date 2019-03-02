<?php
/**
 * @package  Divante\PimcoreIntegration
 * @author Bartosz Herba <bherba@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\PimcoreIntegration\Console\Command;

use Divante\PimcoreIntegration\Queue\Processor\AssetQueueProcessorFactory;
use Magento\Framework\App\State;
use Magento\Framework\Registry;

/**
 * Class AssetsImportCommand
 */
class AssetsImportCommand extends AbstractCommand
{
    /**
     * @var AssetQueueProcessorFactory
     */
    private $queueProcessor;

    /**
     * AssetsImportCommand constructor.
     *
     * @param AssetQueueProcessorFactory $queueProcessor
     * @param State $state
     * @param Registry $registry
     * @param null $name
     */
    public function __construct(AssetQueueProcessorFactory $queueProcessor,  State $state,
        Registry $registry, $name = null)
    {
        $this->queueProcessor = $queueProcessor;
        parent::__construct($state, $registry , $name);
    }

    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('divante:queue-asset:process')->setDescription('Process assets queue');
    }

    public function process()
    {
        $this->queueProcessor->create()->process();
    }
}
