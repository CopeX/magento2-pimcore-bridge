<?php
/**
 * @package   Divante\PimcoreIntegration
 * @author    Mateusz Bukowski <mbukowski@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license   See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\PimcoreIntegration\Console\Command;

use Divante\PimcoreIntegration\Queue\Processor\CategoryQueueProcessorFactory;
use Magento\Framework\App\State;
use Magento\Framework\Registry;

/**
 * Class CategoryImportCommand
 */
class CategoryImportCommand extends AbstractCommand
{
    /**
     * @var CategoryQueueProcessorFactory
     */
    private $categoryQueueProcessor;

    /**
     * CategoryImport constructor.
     *
     * @param CategoryQueueProcessorFactory $categoryQueueProcessor
     * @param State $state
     * @param Registry $registry
     * @param null $name
     */
    public function __construct(
        CategoryQueueProcessorFactory $categoryQueueProcessor,  State $state,
        Registry $registry, $name = null) {

        $this->categoryQueueProcessor = $categoryQueueProcessor;
        parent::__construct($state, $registry, $name);
    }

    /**
     * Configures the current command.a
     *
     * @return void
     */
    public function configure()
    {
        $this->setName('divante:queue-category:process');
        $this->setDescription('Process category import queue from Pimcore');
    }

    public function process()
    {
        $this->categoryQueueProcessor->create()->process();
    }

}
