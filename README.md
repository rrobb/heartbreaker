# Heartbreaker
```
Hey fellas, have you heard the news?
You know that Annie's back in town
It won't take long, just watch and see
How the fellas lay their money down

  -- Led Zeppelin
```
A simple Heartbreak game.

## Installation
- The installation procedure assumes the presence of [Docker](https://www.docker.com/get-started)
- Pull the *heartbreaker* repo
- Open a terminal window and move to the install directory
- Run `make build` to build the container
- Run `make start` to run it
- Then in a separate terminal window run `make run` to run the game directly on the command line 

## Other available commands
All to be run in a separate terminal window:
  - Run `make ssh` to open the container's command line
  - Run `make all-tests` to run all available tests
  - Run `make unit-tests` to run the unit tests
  - Run `make integration-tests` to run the integration tests
  - Run `make functional-tests` to run the functional tests

## Info
The main entrypoint is through `Heartbreaker\Controllers\GameLogic->gameLoop()`.
Here we use a *Chain of Responsabilities* type pattern to handle all game stages.

As the game adheres strictly to the business rules provided, there's not much 'intelligence' at play...
Some slight optimizations of the play style are found in `Heartbreaker\Controllers\GameStrategy.php`.
