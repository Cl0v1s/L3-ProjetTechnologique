sudo service docker start
sudo docker build -t apache-php-dev .
sudo docker run --name lamp -it -d apache-php-dev /bin/bash
sudo docker exec -i -t lamp /bin/bash


# Lancer le container 
# reconfigure mysql-server
# reconfigure phpmyadmin
