$packages = [
  "ca-certificates",
  "git",
  "htop",
  "vim",
]

package { $packages: }

apt::source { "packages.sury.org_php":
  location => "https://packages.sury.org/php",
  release  => "stretch",
  repos    => "main",
  key      => {
    id     => "DF3D585DB8F0EB658690A554AC0E47584A7A714D",
    source => "https://packages.sury.org/php/apt.gpg",
  },
  require  => Package["ca-certificates"],
}

apt::pin { "packages.sury.org_php":
  priority   => 1000,
  originator => "deb.sury.org",
  require    => Apt::Source["packages.sury.org_php"],
}

$php_modules = [
  "cli",
  "mysql",
  "xml"
]

$php_modules.each | $module | {
  package { "php7.2-${module}":
    require => [
      Apt::Source["packages.sury.org_php"],
      Apt::Pin["packages.sury.org_php"],
    ],
  }
}

class { "apache":
  mpm_module    => "prefork",
  default_vhost => false,
  manage_user   => false,
  user          => "vagrant",
  group         => "vagrant",
}

package { "libapache2-mod-php7.2":
  require => [
    Class["apache"],
    Apt::Source["packages.sury.org_php"],
    Apt::Pin["packages.sury.org_php"],
  ],
}

class { "apache::mod::php":
  php_version => "7.2",
}
include apache::mod::rewrite

apache::vhost { "localhost":
  port     => 80,
  docroot  => "/opt/ejabberd-archive-viewer/httpdocs",
  override => ["All"],
}

class { "composer":
  command_name => "composer",
  target_dir   => "/usr/local/bin",
  require      => Package["php7.2-cli"],
}

exec { "composer_install":
  path        => ["/usr/local/sbin", "/usr/local/bin", "/usr/sbin", "/usr/bin", "/sbin", "/bin"],
  command     => "composer install",
  cwd         => "/opt/ejabberd-archive-viewer",
  environment => ["HOME=/home/vagrant"],
  require     => Class["composer"],
}