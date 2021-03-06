<?php
/**
 * @package   Divante\PimcoreIntegration
 * @author    Mateusz Bukowski <mbukowski@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license   See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\PimcoreIntegration\Console\Command;

use Divante\PimcoreIntegration\Queue\Processor\ProductQueueProcessorFactory;
use Magento\Framework\App\State;
use Magento\Framework\Registry;

/**
 * Class ProductImportCommand
 */
class ProductImportCommand extends AbstractCommand
{
    /**
     * @var ProductQueueProcessorFactory
     */
    private $productQueueProcessor;

    /**
     * ProductImport constructor.
     * @param ProductQueueProcessorFactory $productQueueProcessor
     * @param State                 $state
     * @param Registry              $registry
     * @param null                  $name
     */
    public function __construct(
        ProductQueueProcessorFactory $productQueueProcessor,
        State $state,
        Registry $registry,
        $name = null
    ) {
        parent::__construct($state, $registry, $name);
        $this->productQueueProcessor = $productQueueProcessor;
    }

    /**
     * Configures the current command.
     * @return void
     */
    public function configure()
    {
        $this->setName('divante:queue-product:process');
        $this->setDescription('Process all new published products from Pimcore');
    }

    public function process()
    {
        $this->productQueueProcessor->create()->process();
    }

}
