CQRS
======================

*TODO* Add description

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
    eval $(docker-machine env cqrs)
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

### Windows

*TODO*



DNS Configuration
=================

Configure the following hosts in your local `/etc/hosts`.
Make sure you replace the ip address to the ip address of your docker host.

```
192.168.99.100  api.cqrs.dev
```


Development environment
=======================

Clone this repository
---------------------

```bash
git clone https://github.com/TijmenWierenga/cqrs.git
cd cqrs
```

Kickstart environment
---------------------------------------

The following command will kickstart the environment:

```bash
make build
```


Usage
=====

Teardown environment
-------------------

The following command will teardown the environment:

```bash
make teardown
```

Testing environment
-------------------

With the following command you will able to run tests to the environment:

```bash
make test
```

MongoDB
-----

MongoDB server is accessible on port `27017`:

Redis
-----

Redis server is accessible on port `6379`:


Change docker-machine memory
----------------------------
When you need more memory inside your `docker-machine` VM run the following commands on your host os:

```
VBoxManage controlvm default poweroff
VBoxManage modifyvm default --memory 2048
VBoxManage startvm default --type headless
```
