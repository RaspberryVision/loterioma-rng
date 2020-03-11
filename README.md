# LoterioMa RNG

Generator of random numbers mechanism. This is part of LoterioMa casino infrastructure.

## Getting Started

Random number generator system, used when operating casino games in the LoterioMa casino system. The system is based on Symfony 5, communication is done using the API (token authentication).

### Prerequisites

To start work with docker you must install docker and docker-compose.

### Installing

In project directory type:
```
sudo docker-compose up -d
```

This command runs app container (name = loterio_ma_rng), by default it is available under port 9901 (mapping from port 8080).

## Tests

We try to use TDD in the system and write our tests mainly based on PHPUnit.

### Basic info about testing

In the whole project it is recommended to use the TDD approach, which assumes creating tests before the main logic. The following testing methods are recommended:
1. Unit tests in the case of business logic, this applies to services or other classes that perform operations on objects.
2. API tests - for the methods available in the API.
3. Integration tests - a kind of tests aimed at verifying the correct mechanics of the application's operation (correct saving to the database).
4. Functional tests - tests designed to verify what the user sees. Note, these tests only have the right to be used in applications that serve the graphical interface.

Comments:
- test cases stored in separate files.
- each test should have between 4 and 10 test cases.

### How to run tests
Tests are run using PHPUnit, this happens immediately after firing the application container. However, to run the tests manually:

Interactive open docker container:
```
sudo docker-compose exec loterio_ma_rng bash
```

After successive firing inside the container please enter:

```
php bin/phpunit
```

Test results will be returned to the console, beware - in the absence of additional parameters, all tests will be run (this operation may take some time - it is worth considering firing specific TestSuite).

## Code standards

I think it's worth getting into the docker's container https://github.com/jakzal/phpqa.

### Description
**PHP Code_Sniffer** – checks code style, has got popular conventions build-in (e.g. PSR-2, Symfony2).  
**PHP Mess Detector** – looks for potential problems, such as possible bugs, dead code, suboptimal code, overcomplicated expressions, etc.  
**PHP Depend** – can generate set of software metrics for code structure (see further).  
**PHP Copy/Paste Detector** – scans project for duplicated code.  
**PHPLOC** – measures the size of PHP project.  
**PHPUnit** – runs unit tests and is used as a runner for other test tools.  
All scripts are located in the .dev directory. Also in it (in the report catalog) you will find the results of the script.

## Deployment

We can two application instances:
1. **DEV** - develop instance, this is  continuous integration branch. After merge to `develop` this instance build automatically.
2. **PROD** - production instance, related to master branch.

Application is available on address:
193.70.113.241:9901

## Contributing

-

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Rafal Malik** - *Main developer* - [RafalMalik](https://github.com/RafalMalik)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

K. L. for every wonderful moment.
