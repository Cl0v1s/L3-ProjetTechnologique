sudo service docker start
sudo docker build -t apache-php-dev .
cd ..
sudo docker run -p 81:80 -v $(pwd)/Src/Back:/var/www/html --name lamp -it -d apache-php-dev /bin/bash
read -p "Une console va se lancer, effectuez apt-get install phpmyadmin, en selectionnant toutes les options par defaut (pas de mot de passe), puis quittez avec exit"
sudo docker exec -i -t lamp /bin/bash

