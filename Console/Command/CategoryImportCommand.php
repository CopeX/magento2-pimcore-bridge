<?php
/**
 * @package   Divante\PimcoreIntegration
 * @author    Mateusz Bukowski <mbukowski@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license   See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\PimcoreIntegration\Console\Command;

use Divante\PimcoreIntegration\Queue\Processor\CategoryQueueProcessor;
use Magento\Framework\App\ObjectManagerFactory;

/**
 * Class CategoryImportCommand
 */
class CategoryImportCommand extends AbstractCommand
{
    /**
     * @var CategoryQueueProcessor
     */
    private $categoryQueueProcessor;

    /**
     * CategoryImport constructor.
     *
     * @param CategoryQueueProcessor $categoryQueueProcessor
     * @param State $state
     * @param Registry $registry
     * @param null $name
     */
    public function __construct(
        CategoryQueueProcessor $categoryQueueProcessor, ObjectManagerFactory $objectManagerFactory, $name = null) {

        $this->categoryQueueProcessor = $categoryQueueProcessor;
        parent::__construct($objectManagerFactory, $name);
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
        $this->categoryQueueProcessor->process();
    }

}
