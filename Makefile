.PHONY: deploy installNoDev installWithDev test server e2e

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

test: installWithDev build/image_map.php
	./vendor/bin/phpunit --coverage-html build/coverage/

server: installWithDev build/image_map.php
	dev_appserver.py app.yaml -A 'local-dev-app-id'

e2e: installWithDev build/image_map.php
	{ dev_appserver.py app.yaml -A 'local-dev-app-id' --datastore_path=':memory:' --logs_path=':memory:' 2> build/server.log & }; \
		pid=$$! ; \
		sleep 2 ; \
		echo "kill -0 $$pid" ; \
		if kill -0 $$pid ; then echo "Server running, pid is [$$pid]"; else echo "PID [$$pid] not valid! Failed to start server!"; exit -1;  fi && \
		echo 'TODO: DO TESTING HERE' && \
		echo Stopping server && \
		kill -s INT $$pid && \
		echo Done
