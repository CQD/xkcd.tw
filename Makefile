.PHONY: deploy installNoDev installWithDev server

STRIP_IMAGES = $(wildcard public/strip/*.*)

installNoDev:
	composer install -o --no-dev

installWithDev:
	composer install -o

build/image_map.php: ${STRIP_IMAGES}
	bin/build_image_map

server: installWithDev build/image_map.php
	php -S 0.0.0.0:8080 -t public/

textframe:
	bin/1190_textframe
