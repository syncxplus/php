# Install #
```php
composer install --no-dev --prefer-dist --optimize-autoloader
```
&nbsp;&nbsp;Or, install from docker
```php
docker run --name php --rm -p 80:80 -v $PWD:/var/www -d registry.aliyuncs.com/syncxplus/php:7.2.9
docker exec -it php composer install -d /var/www  --no-dev --prefer-dist --optimize-autoloader
```
&nbsp;&nbsp;Install font
```php
curl -o ./html/SourceHanSansSC-Normal.otf -L https://github.com/adobe-fonts/source-han-sans/raw/release/OTF/SimplifiedChinese/SourceHanSansSC-Normal.otf
```
# Test #
```php
composer install --prefer-dist --optimize-autoloader
./vendor/bin/phpunit -c phpunit.xml test
./vendor/bin/phpunit test/db
./vendor/bin/phpunit test/db/MysqlTest
./vendor/bin/phpunit test/db/MysqlTest.php
```
