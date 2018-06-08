$script = <<SHELL
    apt-get update

    for module in {puppetlabs-apache,puppetlabs-apt,willdurand-composer}; do
        puppet module install --target-dir /opt/ejabberd-archive-viewer/vagrant/puppet/test/modules $module
    done
SHELL

Vagrant.configure(2) do |config|
    config.vm.box = "debian/stretch64"
    config.vm.network "forwarded_port", guest: 80, host: 8080, auto_correct: true
    config.vm.synced_folder ".", "/opt/ejabberd-archive-viewer"
    config.vm.provision "shell",
        inline: $script
    config.vm.provision "puppet" do |puppet|
        puppet.environment_path = "vagrant/puppet"
        puppet.environment = "test"
    end
    config.puppet_install.puppet_version = "4.10.9"
end