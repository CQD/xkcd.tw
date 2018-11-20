.PHONY: deploy installNoDev installWithDev server

STRIP_IMAGES = $(wilcard public/strip/*.*)

installNoDev:
	composer install -o --no-dev

installWithDev:
	composer install -o

build/image_map.php: ${STRIP_IMAGES}
	bin/build_image_map

deploy: installNoDev build/image_map.php
	-rm -rf vendor/*/*/tests
	-rm -rf vendor/*/*/test
	-rm -rf vendor/*/*/docs
	-rm -rf vendor/*/*/doc
	gcloud app deploy -v 'prod'  --project='sonorous-cacao-89706'

server: installWithDev build/image_map.php
	php -S localhost:8080 -t public/
