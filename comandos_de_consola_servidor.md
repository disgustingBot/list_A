### Para hacer una migracion interna (mover de un lugar a otro)
rsync -a /var/www/domain.com/public_html/ /var/www/domain.com/public_html_backup/
rsync -a /home/unica/web/unicalovelyshoes.com/public_html/ bdebonica@localhost:/home/bdebonica/web/bdebonica.com/public_html/

bdebonica.com

admin
dcd7314cdna7c71fcd.ed4689h
### Para zipear un sitio
zip -r wepol.zip ~web/encuesta/public_html

cd ~/web/nombre_del_sitio/public_html
zip -r awake.zip .


### Para enviar un archivo

scp [OPTION] [user@]SRC_HOST:]file1 [user@]DEST_HOST:]file2
<!-- scp lattedev@host.trespiweb.com:/home/lattedev/web/encuesta/wepol.zip /mnt/c/xampp/htdocs/encuesta -->
scp lattedev@main.wave-host.net:~/web/encuesta/public_html/wepol_right.zip /mnt/c/xampp/htdocs/encuesta
scp lattedev@main.wave-host.net:~/web/encuesta_db.sql /mnt/c/xampp/htdocs/encuesta

### Para importar una base de datos:

mysql -h bbdd-webtoolsapps.e-encuesta.com -u wp_encuesta -p wp_encuesta < path/to/database/file/encuesta_db.sql
mysql -h localhost -u bdebonica_wp -p bdebonica_wp < /home/bdebonica/web/my_db.sql

### Para exportar una base de datos alojada en un servidor:

mysqldump -h hostdelabase.com -u usuariodebase -p nombrebase > db.sql
mysqldump -h localhost -u lattedev_awake -p lattedev_awake > /home/lattedev/web/despertar/my_db.sql
mysqldump -h localhost -u lattedev_encuesta -p lattedev_encuesta > /home/lattedev/web/encuesta_db.sql

OfhrHNlKE7MAmT3e


Primero migrar todo y AL FINAL hacer la transferencia de DNS


<!-- PARA MIGRACION DE MAILS DE UN SERVIDOR A OTRO (el nuestro) -->
imapsync --host1 hostdemierda.com --ssl1 --user1 info@gpmotorbikes.com --password1 NCDJNCDJNCAJD --host2 localhost --ssl2 --user2 info@gpmotorbikes.com --password2 s7sxXolz7c

### Para migrar mails de un servidor a otro (el nuestro):
1)_ crear cuentas de correo para recibir los mail en nuestro servidor (usar mismas credenciales)
2)_ usar el siguiente comando desde putty:

imapsync \
    --host1 test1.lamiral.info --user1 test1 --password1 secret1 \
    --host2 test2.lamiral.info --user2 test2 --password2 secret2


ejemplo mas real:

imapsync \
    --host1 1and1.es  --user1 alcafax@alcasl.com --password1 Coyo$-90a \
    --host2 localhost --user2 alcafax@alcasl.com --password2 Coyo$-90a


imapsync \
    --host1 209.126.15.52  --user1 alcafax@alcasl.com --password1 Coyo$-90a \
    --host2 localhost --user2 alcafax@alcasl.com --password2 Coyo$-90a



el otro server:
http://smtp.1and1.es
nuestro server:
localhost (porque ejecutamos el comando desde nuestro server)

alcafax@alcasl.com
Coyo$-90a










rsync -zav usuario@host:/directorio/a/la/public/ ./
