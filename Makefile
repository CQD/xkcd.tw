.PHONY: deploy installNoDev installWithDev server

STRIP_IMAGES = $(wildcard public/strip/*.*)

installNoDev:
	composer install -o --no-dev

installWithDev:
	composer install -o

build/image_map.php: ${STRIP_IMAGES}
	bin/build_image_map

deploy: installNoDev build/image_map.php
	gcloud app deploy -v 'prod'  --project='sonorous-cacao-89706'
	bin/notify_p10b

server: installWithDev build/image_map.php
	php -S localhost:8080 -t public/

textframe:
	bin/1190_textframe
