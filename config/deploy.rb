# config valid only for Capistrano 3.1
lock '3.1.0'

# require Slack config
require './config/slack'

############################################
# Setup WordPress
############################################

set :wp_user, "lvalenzuela" # The admin username
set :wp_email, "li.valenzuelaa@gmail.com" # The admin email address
set :wp_sitename, "Infinithink" # The site title
set :wp_localurl, "http://localhost" # Your local environment URL

############################################
# Setup project
############################################

set :application, "infinithink"
set :repo_url, "git@github.com:lvalenzuela/infinithink.git"
set :scm, :git

set :git_strategy, SubmoduleStrategy

############################################
# Setup Capistrano
############################################

set :log_level, :info
set :use_sudo, false

set :ssh_options, {
  forward_agent: true
}

set :keep_releases, 5

############################################
# Linked files and directories (symlinks)
############################################

set :linked_files, %w{wp-config.php .htaccess}
set :linked_dirs, %w{content/uploads}

namespace :deploy do

  desc "create WordPress files for symlinking"
  task :create_wp_files do
    on roles(:app) do
      execute :touch, "#{shared_path}/wp-config.php"
      execute :touch, "#{shared_path}/.htaccess"
    end
  end

  after 'check:make_linked_dirs', :create_wp_files

  desc "Creates robots.txt for non-production envs"
  task :create_robots do
  	on roles(:app) do
  		if fetch(:stage) != :production then

		    io = StringIO.new('User-agent: *
Disallow: /')
		    upload! io, File.join(release_path, "robots.txt")
        execute :chmod, "644 #{release_path}/robots.txt"
      end
  	end
  end

  desc "symlinks WordPress template files"
  task :create_template_files do
    on roles(:app) do
      execute :ln, "-nfs #{shared_path}/psd.zip #{release_path}/content/themes/Avada_Full_Package/"
    end
  end

  desc "unzip WordPress Template Files"
  task :unzip_wp_themes do
    on roles(:app) do
      execute :unzip, "#{release_path}/content/themes/Avada/Avada_Full_Package/Avada\ Theme/Avada.zip"
      execute :unzip, "#{release_path}/content/themes/Avada/Avada_Full_Package/Avada\ Theme/Avada-Child-Theme.zip"
    end
  end

  after :finished, :create_robots
  after :create_robots, :create_template_files
  after :finishing, "deploy:cleanup"

end
