# Thingston HTTP Exception

A set of custom PHP Exception based on HTTP Status Code.

## Requirements

- PHP 8.1

## Instalation

`composer require thingston/http-exception`

## Usage

Please check the [Documentation](https://github.com/thingston/http-exception/wiki).

## Testing

Available Composer scripts:

- `composer run test` - Runs all tests using PHPUnit.
- `composer run coverage:text` - Runs all tests using PHPUnit and generates a coverage report to the console.
- `composer run coverage:clover` - Runs all tests using PHPUnit and generates an XML coverage report to file `coverage.xml`.
- `composer run coverage:html` - Runs all tests using PHPUnit and generates an XML coverage report to directory `coverage`.
- `composer run coverage:check` - Runs the `coverage:clover` script and checks the code coverage rate (requires >= 90%).
- `composer run analyze` - Runs the PHPStan static analysis and displays the results to the console.
- `composer run cs` - Runs the Code Sniffer static analysis and displays any errors to the console.
- `composer run cbf` - Runs the Code Sniffer code fixer and displays the results to the console.
- `composer run checks` - Runs the scripts `cs`, `analyze` and `coverage:check` and displays the results to the console.

## Support

- Issues: https://github.com/thingston/http-exception/issues
- Documentation: https://github.com/thingston/http-exception/wiki