# Ejabberd Archive Viewer

[![DockerHub](https://img.shields.io/badge/download-DockerHub-blue?logo=docker)](https://hub.docker.com/r/programie/ejabberdarchiveviewer)
[![GitHub release](https://img.shields.io/github/v/release/Programie/EjabberdArchiveViewer)](https://github.com/Programie/EjabberdArchiveViewer/releases/latest)

## Installation and configuration

### Classic installation

**Note:** The application requires a webserver with PHP configured.

* Download the latest release and extract it onto your webserver
* Point your web server to the `httpdocs` directory
* Copy [src/main/resources/config.sample.ini](src/main/resources/config.sample.ini) to `src/main/resources/config.ini` and modify it to fit your environment

### Installation with Docker

Create a `config.ini` and configure your database connection.

Example:

```ini
[database]
dsn = mysql:host=localhost;dbname=ejabberd
username = root
password =
```

Start the container and mount the `config.ini` into the container at `/app/src/main/resources/config.ini`:

```
docker run --name ejabberdarchiveviewer -p 8080:80 -v /path/to/config.ini:/app/src/main/resources/config.ini:ro programie/ejabberdarchiveviewer
```

Now the application will be reachable at http://localhost:8080.

## Testing in Vagrant VM

Note: This was only tested with VirtualBox as provider.

* Install Vagrant plugins (if not already installed):
  * VirtualBox guest plugin: `vagrant plugin install vagrant-vbguest`
  * Puppet install plugin: `vagrant plugin install vagrant-puppet-install`
* Run `vagrant up` to setup the Vagrant VM.
* The viewer will be available on the configured port on localhost ([http://localhost:8080](http://localhost:8080) by default)