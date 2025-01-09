# ShotDuell
A drinking game for the next block party
This game can be played completely within a Webbrowser.

![Default View](https://raw.githubusercontent.com/koneca/ShotDuell/refs/heads/master/doc/images/defaultView.png "The default view")

It consists of the default view, which is thought to be shown at the Bar on a big screen.
Also it haves the bar view, from which the bartender can add/delete/modify teams and also addup the shots drunken by the team.

TODO:
- Statistics 
- installer


## Installation
This game is based on the [Symfony framework](https://symfony.com/doc/current/setup.html).
After cloning this Repository change to it's directory and execute composer:

Also php extension xml, sqlite3 and the -dev package is needed.
```
$ cd ShotDuell
$ composer install
```

After all dependencies have been cleare, please run:
``` 
$ php bin/console doctrine:schema:update --force
```

To configure the DB.

## Run ShotDuell
If all dependencies have been met the ShotDuell now can be started.
To do so please run: 
```
symfony server:start -d
```
As one can see from the prompt, the page is now reachable at http://localhost:8000

### Views

#### The DefaultView
![Default View](https://raw.githubusercontent.com/koneca/ShotDuell/refs/heads/master/doc/images/defaultView.png "The default view")
The DefaultView is loaded when accessing the root of the webpage by http://localhost:8000. It shows the Teams and their scores and also is/can be nicely animated.

#### The BarView
![Default View](https://raw.githubusercontent.com/koneca/ShotDuell/refs/heads/master/doc/images/barView.png "The Bar view")
This view is intened for the bartender to use to manage the teams.
It can be entered by clicking on the Logo which is shown on the upper right corner at the DefaultView.
Also it can be accessed directly by path: http://localhost:8000/barView.

#### Manage Teams View
![Default View](https://raw.githubusercontent.com/koneca/ShotDuell/refs/heads/master/doc/images/manageTeams.png "The manage view")
This view allows the bartender to manage the teams as create and delete .

## Optional
Optional the ShotDuell could be started on system start and the Browser