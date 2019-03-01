<?php
/**
 * @package   Divante\PimcoreIntegration
 * @author    Mateusz Bukowski <mbukowski@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license   See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\PimcoreIntegration\Console\Command;

use Divante\PimcoreIntegration\Queue\Processor\ProductQueueProcessor;
use Magento\Framework\App\ObjectManagerFactory;

/**
 * Class ProductImportCommand
 */
class ProductImportCommand extends AbstractCommand
{
    /**
     * @var ProductQueueProcessor
     */
    private $productQueueProcessor;
    
    /**
     * ProductImport constructor.
     *
     * @param ProductQueueProcessor $productQueueProcessor
     * @param State $state
     * @param Registry $registry
     * @param null $name
     */
    public function __construct(
        ProductQueueProcessor $productQueueProcessor,
        ObjectManagerFactory $objectManagerFactory, $name = null
    ) {
        parent::__construct($objectManagerFactory, $name);
        $this->productQueueProcessor = $productQueueProcessor;
    }

    /**
     * Configures the current command.a
     *
     * @return void
     */
    public function configure()
    {
        $this->setName('divante:queue-product:process');
        $this->setDescription('Process all new published products from Pimcore');
    }

    public function process()
    {
        $this->productQueueProcessor->process();
    }

}
