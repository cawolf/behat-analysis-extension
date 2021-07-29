# Behat analysis extension

This extension provides analysis metrics to maintain big and growing behat suites and contexts. It does

* accumulate running times of steps and hooks, allowing to find the slowest parts of your suite

## Installation

This extension requires:

* Behat 3.0+

### Use [composer](http://getcomposer.org)

1. Run composer with
    
        composer require --dev cawolf/behat-analysis-extension
        
    or define dependencies in your ``composer.json``:

        {
            "require-dev": {
                ...

                "cawolf/behat-analysis-extension": "*"
            }
        }
        
2. Activate extension by specifying its class in your ``behat.yml``:

        # behat.yml
        default:
          # ...
          extensions:
            Cawolf\Behat\Analysis: ~

## Usage

Run your behat suite as usual:
        
        vendor/bin/behat -s default

## Contributors

* Christian A. Wolf [cawolf](http://github.com/cawolf)
* Sébastien Terodde [MollocH](https://github.com/MollocH)
