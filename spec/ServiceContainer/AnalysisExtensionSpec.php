<?php

namespace spec\Cawolf\Behat\Analysis\ServiceContainer;

use Behat\Behat\Tester\ServiceContainer\TesterExtension;
use Behat\Testwork\Cli\ServiceContainer\CliExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Cawolf\Behat\Analysis\Controller\Output;
use Cawolf\Behat\Analysis\Printer\Result;
use Cawolf\Behat\Analysis\ServiceContainer\AnalysisExtension;
use Cawolf\Behat\Analysis\Tester\Feature;
use Cawolf\Behat\Analysis\Tester\Suite;
use Cawolf\Behat\Analysis\Timing\Accumulator;
use PhpSpec\ObjectBehavior;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AnalysisExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AnalysisExtension::class);
        $this->shouldHaveType(Extension::class);
    }

    function it_is_named_analysis()
    {
        $this->getConfigKey()->shouldReturn('analysis');
    }

    function it_is_configurable(ArrayNodeDefinition $builder)
    {
        $this->configure($builder);
    }

    function it_loads_all_services(ContainerBuilder $container)
    {
        $this->setDefinitionShouldBeCalled($container, Accumulator::SERVICE_ID, Accumulator::class);
        $this->setDefinitionShouldBeCalled($container, TesterExtension::SUITE_TESTER_WRAPPER_TAG . Suite::SERVICE_SUFFIX, Suite::class);
        $this->setDefinitionShouldBeCalled($container, TesterExtension::SPECIFICATION_TESTER_WRAPPER_TAG . Feature::SERVICE_SUFFIX, Feature::class);
        $this->setDefinitionShouldBeCalled($container, Result::SERVICE_ID, Result::class);
        $this->setDefinitionShouldBeCalled($container, CliExtension::CONTROLLER_TAG . Output::SERVICE_SUFFIX, Output::class);

        $this->load($container, []);
    }

    /**
     * @param ContainerBuilder $container
     * @param string $serviceId
     * @param string $className
     */
    private function setDefinitionShouldBeCalled(ContainerBuilder $container, $serviceId, $className)
    {
        $definition = Argument::that(
            function (Definition $definition) use ($className) {
                Assert::assertEquals(
                    $className,
                    $definition->getClass(),
                    sprintf(
                        'expected %s, got %s',
                        $className,
                        $definition->getClass()
                    )
                );
                return true;
            }
        );
        $container->setDefinition($serviceId, $definition)->shouldBeCalled();
    }
}
