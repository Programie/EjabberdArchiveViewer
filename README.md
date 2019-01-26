# Ejabberd Archive Viewer

## Configuration

* Point your web server to the httpdocs directory.
* Copy [src/main/resources/config.sample.ini](src/main/resources/config.sample.ini) to src/main/resources/config.ini and modify it to fit your environment.

## Testing in Vagrant VM

Note: This was only tested with VirtualBox as provider.

* Install Vagrant plugins (if not already installed):
  * VirtualBox guest plugin: `vagrant plugin install vagrant-vbguest`
  * Puppet install plugin: `vagrant plugin install vagrant-puppet-install`
* Run `vagrant up` to setup the Vagrant VM.
* The viewer will be available on the configured port on localhost ([http://localhost:8080](http://localhost:8080) by default)