# test_musement README 
---------------------
[![Quality gate](https://sonarcloud.io/api/project_badges/quality_gate?project=msalguer_test_musement)](https://sonarcloud.io/dashboard?id=msalguer_test_musement)

This is a test developed in Symfony 4. With Testing TDD and passing Sonarlint static analysis.

### Author: Manuel Salguero

# Description

This is a test exercise from this project:
https://gist.github.com/hpatoio/3aeea8159fb9046a2feba75d39a8d21e

Gets the list of the cities from Musement's API for each city gets the forecast for the next 2 days using http://api.weatherapi.com and print to STDOUT "Processed city [city name] | [weather today] - [wheather tomorrow]"

### Requirements

* PHP >=7.3
* Symfony 4.x

### Test app:
php bin/phpunit -v

### Run app:
php bin/console server:run

### Log file tests passed:
testresults.log

### Run in Docker container:
* docker pull msalguer/test_musement
* docker run -p 8000:8000 --name cmuse -d msalguer/test_musement
* Test with: http://127.0.0.1:8000

### OpenApi definition for musement test exercise:
Openapi folder contains full openapi modified, and files with fragments of changes.

### Static analysis with SonarQube
https://sonarcloud.io/dashboard?id=msalguer_test_musement

