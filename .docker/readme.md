general info:
    -for deploying on usual hosting:
        -edit the host in database configration file and change it to localhost

docker related:
    -all the docker data(Dockerfile, docker-compose, and appropriate config files) is present in docker directory.
    -permissions prefferd '755', other permissions lead to security errors especially in MySQL
    -laravel storage/ permissions preffered '777', other permissions lead to permission errors
    -configuration made in httpd.conf(Apache):
        -added virtualhost
        -enabled proxy modules
        -enable mod_rewrite module
    -configuration made in my.cnf(MySQL):
        -none
    -configuration made in php.ini(PHP):
        -none
    -for deploying on any cloud service like AWS or DigitalOcean:
        -edit the host in database configration file and change it to the container name running database