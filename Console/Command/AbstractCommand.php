<?php

namespace Divante\PimcoreIntegration\Console\Command;

use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Framework\App\ObjectManagerFactory;
use Magento\Store\Model\StoreManager;
use Magento\Store\Model\Store;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
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
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;
    
    /**
     * Object manager factory
     *
     * @var ObjectManagerFactory
     */
    protected $objectManagerFactory;
    
    /**
     * @var InputInterface $inputInterface
     */
    protected $inputInterface;

    /**
     * @var OutputInterface $outputInterface
     */
    protected $outputInterface;

    /**
     * AbstractCommand constructor.
     * @param ObjectManagerFactory $objectManagerFactory
     * @param null                 $name
     */
    public function __construct( ObjectManagerFactory $objectManagerFactory, $name = null)
    {
        $this->objectManagerFactory = $objectManagerFactory;

        parent::__construct($name);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->inputInterface = $input;
        $this->outputInterface = $output;
        $omParams = $_SERVER;
        $omParams[StoreManager::PARAM_RUN_CODE] = 'admin';
        $omParams[Store::CUSTOM_ENTRY_POINT_PARAM] = true;
        // Need to use object manager because in some cercumstances areaCode will otherwise not be set correct
        $this->objectManager = $this->objectManagerFactory->create($omParams);
        $this->objectManager->get("Magento\Framework\Registry")->register('isSecureArea', true);
        $area = FrontNameResolver::AREA_CODE;

        /** @var \Magento\Framework\App\State $appState */
        $appState = $this->objectManager->get('Magento\Framework\App\State');
        $appState->setAreaCode($area);
        $configLoader = $this->objectManager->get('Magento\Framework\ObjectManager\ConfigLoaderInterface');
        $this->objectManager->configure($configLoader->load($area));


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