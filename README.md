FXGP Development Stack
======================

This repository contains all the needed scripts to download and start a development (or testing) stack of FXGP.

Prerequisites
=============

Installation of workstation
---------------------------

### OS X

1. Install [Docker Toolbox](https://www.docker.com/products/docker-toolbox).
The *Toolbox* is recommended over *Docker For Mac* because it allows you to use NFS which is must faster.

2. Install [Docker Machine NFS](https://github.com/adlogix/docker-machine-nfs) to speed up filesystem sharing.

    ```bash
    curl -s https://raw.githubusercontent.com/adlogix/docker-machine-nfs/master/docker-machine-nfs.sh |
      sudo tee /usr/local/bin/docker-machine-nfs > /dev/null && \
      sudo chmod +x /usr/local/bin/docker-machine-nfs
    ```

3. Start a new docker-machine

    ```bash
    make create_docker_machine
    eval $(docker-machine env)
    ```

### Linux (Debian/Ubuntu)

* Install Docker Engine >= 1.12 ([Debian](https://docs.docker.com/engine/installation/debian/) or [Ubuntu](https://docs.docker.com/engine/installation/ubuntulinux/))

* Make sure you change the default mtu to prevend problems over VPN.

    ```bash
    sudo systemctl stop docker
    sudo ip link del docker0
    sudo mkdir -p /etc/systemd/system/docker.service.d/
    echo -e "[Service]\nExecStart=\nExecStart=/usr/bin/dockerd -H fd:// --mtu 1024" | sudo tee /etc/systemd/system/docker.service.d/mtu.conf
    sudo systemctl daemon-reload
    sudo systemctl start docker
    ```

* Install [Docker Compose](https://docs.docker.com/compose/install/) >= 1.8

* Update max_map_count for elasticsearch:

    ```bash
    sysctl -w vm.max_map_count=262144
    ```

### Windows

*TODO*



DNS Configuration
=================

Configure the following hosts in your local `/etc/hosts`.
Make sure you replace the ip address to the ip address of your docker host.

```
192.168.99.100  www.d.freeones.com admin.d.freeones.com api.d.freeones.com cdn.d.freeones.com es.d.freeones.com rabbitmq.d.freeones.com mail-catcher.d.freeones.com
192.168.99.100  www.d.maleones.com admin.d.maleones.com api.d.maleones.com cdn.d.maleones.com es.d.maleones.com rabbitmq.d.maleones.com mail-catcher.d.maleones.com
```


Development environment
=======================

Add SSH key to bitbucket
------------------------

Make sure you have a SSH key otherwise generate it:

```bash
ssh-keygen -t rsa
```

Copy the contents of your public key (normally ~/.ssh/id_rsa.pub) to Bitbucket:
https://bitbucket.funix.nl/plugins/servlet/ssh/account/keys/add

Clone this repository
---------------------

```bash
git clone ssh://git@bitbucket.funix.nl:7999/fxgp/dev.git
cd dev
```

Kickstart your development environment
---------------------------------------

The following commands will kickstart a fresh development environment.
See below for more detailed description.

```bash
make projects_pull projects_setup images_pull launch_logging
STACK=freeones make launch database_seed
STACK=maleones make launch database_seed
```

You can also export STACK and use defaultly set stack until end of terminal session
```
export STACK=freeones
make launch database_seed
```

Usage
=====

Update projects
---------------

This will pull all project git repositories

```bash
make projects_pull
```

Next step is to setup each repository with the right permissions and install composer packages:

```bash
make projects_setup
```

Launch logging stack
--------------------

This will start Graylog and required services

```bash
make launch_logging
```

Launch FXGP stack
-----------------

First download the latest Docker images

```bash
make images_pull
```

Start the development stack

```bash
STACK=freeones make launch
```

Seed database
-------------

Run the following task for each stack if you want to seed the database with test data: 

```bash
STACK=freeones make database_seed
```

Running console commands
------------------------

It is possible to run a console command inside the container like this:

```bash
docker exec -it --user www-data freeones_frontend_1 bin/console cache:clear 
```


Stopping & Teardown
-------------------

To stop the stack run:

```bash
STACK=freeones make stop
```

The data will be remain and you can start the stack again with the launch task.

To teardown the stack and delete all data run:

```bash
STACK=freeones make teardown
```

To teardown all stacks, logging and proxy run:

```bash
make teardown_all
```

Proxy
-----

Traefik is used as reversed proxy to forward to each container for both stacks.
You can see the dashboard of Traefik on http://192.168.99.100:8080/


```bash
make launch_proxy
make stop_proxy
```

PHPStorm
--------

You can configure to a remote interpreters by:

* Go to `Settings -> Languages & Frameworks -> PHP`
* Click the three dots next to CLI Interpreter
* Add a new Remote interpreter from Docker
* Add a new Server and import it from Docker-Machine
* Use `docker-registry.funix.nl/fxgp/php-ci` as Docker image
* Save the settings. You can now configure other tools like PHPUnit to use this remote interpreter.


Graylog
-------

You can login into the Graylog webinterface with username `admin` and password `freeones` on:
http://192.168.99.100:9000/ 

First time setup:

* Go to "System / Content Packs" and upload the file `graylog.json`.
* Select "OS -> FXGP Dev Configuration" and click "Apply"
* Select "Grok -> Core Grok Patterns" and click "Apply"

Rabbitmq
--------

Management interface is available on http://rabbitmq.d.freeones.com/

You can login as user `fxgp` and password `h},A4bMF`.

MySQL
-----

MySQL server is accessible on different ports for each environment:

*freeones*: 13306
*maleones*: 23306

You can login as user `root` and password `ooso8bah`.

ElasticSearch
-------------

ElasticSearch can be accessed on subdomain `es`, for example: `http://es.d.freeones.com`


Redis
-----

Redis server is accessible on different ports for each environment:

*freeones*: 12201
*maleones*: 22201


Change docker-machine memory
----------------------------

When you need more memory inside your `docker-machine` VM run the following commands on your host os:

```
VBoxManage controlvm default poweroff
VBoxManage modifyvm default --memory 2048
VBoxManage startvm default --type headless
```


VM Max Map Count Error in ElasticSearch
---------------------------------------

When the following error appears:
```
elasticsearch    | ERROR: bootstrap checks failed
elasticsearch    | memory locking requested for elasticsearch process but memory is not locked
elasticsearch    | max virtual memory areas vm.max_map_count [65530] likely too low, increase to at least [262144]
```

Then increase the `max_map_count` of your VM:
```
docker-machine ssh
sudo sysctl -w vm.max_map_count=262144
```


Testing environment
===================

The testing stack is almost identical to the development stack but uses built Docker images and runs in production mode.
It also uses different domain names and typically runs on a remote server.

Launch FXGP stack
-----------------

Follow these steps to start the testing stack:

```bash
# make sure you have the latest images
make pull_images

# make sure you have a working and seeded database
make launch_proxy
STACK=freeones make launch_testing wait_for_database database_create database_migrate cdn_create database_seed
STACK=maleones make launch_testing wait_for_database database_create database_migrate cdn_create database_seed
```

Tear down FXGP stack
--------------------

To tear down the entire stack run (this will remove all data as well):

```bash
STACK=freeones make teardown_testing
STACK=maleones make teardown_testing
make stop_proxy
```

Run behaviour tests
-------------------

Behaviour tests are executed on a running test environment using a headless browser.

To be able to run the tests, you have to pull and setup the projects first

```bash
make projects_pull update_project_to_image projects_setup
```

All dependencies to run the tests should be available.

You can now run the behaviour tests by running:

```bash
make behaviour_test
```
