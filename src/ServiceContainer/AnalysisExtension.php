<?php

namespace Cawolf\Behat\Analysis\ServiceContainer;

use Behat\Behat\Tester\ServiceContainer\TesterExtension;
use Behat\Testwork\Cli\ServiceContainer\CliExtension;
use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Cawolf\Behat\Analysis\Controller\Output;
use Cawolf\Behat\Analysis\Printer\Result;
use Cawolf\Behat\Analysis\Tester\Feature;
use Cawolf\Behat\Analysis\Tester\Suite;
use Cawolf\Behat\Analysis\Timing\Accumulator;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Main extension class, initializes wrappers.
 */
class AnalysisExtension implements Extension
{
    /** @inheritdoc */
    public function process(ContainerBuilder $container)
    {
    }

    /** @inheritdoc */
    public function getConfigKey()
    {
        return 'analysis';
    }

    /** @inheritdoc */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /** @inheritdoc */
    public function configure(ArrayNodeDefinition $builder)
    {
        // TODO: make precision configurable
    }

    /** @inheritdoc */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadTimings($container);
        $this->loadPrinters($container);
        $this->loadTesters($container);
        $this->loadControllers($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function loadTimings(ContainerBuilder $container)
    {
        $definition = new Definition(Accumulator::class);
        $container->setDefinition(Accumulator::SERVICE_ID, $definition);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function loadPrinters(ContainerBuilder $container)
    {
        $definition = new Definition(Result::class, [new Reference(Accumulator::SERVICE_ID)]);
        $definition->addTag(EventDispatcherExtension::SUBSCRIBER_TAG);
        $container->setDefinition(Result::SERVICE_ID, $definition);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function loadTesters(ContainerBuilder $container)
    {
        $definition = new Definition(
            Suite::class, [new Reference(TesterExtension::SUITE_TESTER_ID), new Reference(Accumulator::SERVICE_ID)]
        );
        $definition->addTag(TesterExtension::SUITE_TESTER_WRAPPER_TAG, ['priority' => 10000]);
        $container->setDefinition(
            TesterExtension::SUITE_TESTER_WRAPPER_TAG . Suite::SERVICE_SUFFIX,
            $definition
        );

        $definition = new Definition(
            Feature::class,
            [
                new Reference(TesterExtension::SPECIFICATION_TESTER_ID),
                new Reference(Accumulator::SERVICE_ID)
            ]
        );
        $definition->addTag(TesterExtension::SPECIFICATION_TESTER_WRAPPER_TAG, ['priority' => 10000]);
        $container->setDefinition(
            TesterExtension::SPECIFICATION_TESTER_WRAPPER_TAG . Feature::SERVICE_SUFFIX,
            $definition
        );
    }

    /**
     * @param ContainerBuilder $container
     */
    private function loadControllers(ContainerBuilder $container)
    {
        $definition = new Definition(Output::class);
        $definition->addTag(CliExtension::CONTROLLER_TAG, ['priority' => 100]);
        $container->setDefinition(
            CliExtension::CONTROLLER_TAG . Output::SERVICE_SUFFIX,
            $definition
        );
    }
}
