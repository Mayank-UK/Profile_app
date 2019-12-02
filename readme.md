general info:
    -for deploying on usual hosting:
        -edit the host in database configration file and change it to localhost

docker related:
    -all the docker data(Dockerfile, docker-compose, and appropriate config files) is present in docker directory.
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