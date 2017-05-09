#!/bin/sh


if [ -n "$1" ]; then
	case $1 in
		"proxy")
			docker run \
				-p 80:80 \
				-v /var/run/docker.sock:/tmp/docker.sock:ro \
				-d jwilder/nginx-proxy
		;;
		"api")
			if [ -z $(docker ps -q -f name=db-mysql )]; then
				docker run \
					--name db-mysql \
					-v /usr/src/dbdata:/var/lib/mysql
					-e MYSQL_ROOT_PASSWORD=812KKKlm102 \
					-d mysql
			fi;
			docker rm $(docker ps -q -a -f name=api)
			docker run \
				--name api \
				--expose 80 \
				--link db-mysql:mysql \
				-e MYSQL_HOST=mysql \
				-e VIRTUAL_HOST=api.journal.ru \
				-v /home/ksenkso/college-api/frontend:/app/frontend \
				-v /home/ksenkso/college-api/common:/app/common \
				api:test
		;;
		"wp")
			if [ ! -n $(docker ps -a -q -f name=wordpressdb) ]; then
				docker rm $(docker ps -a -q -f name=wordpressdb)
			fi;
			if [ ! -n $(docker ps -a -q -f name=wordpress) ]; then
				docker rm $(docker ps -a -q -f name=wordpress)
			fi;
			docker run \
				--name wordpressdb \
				-v $HOME/wpdb:/var/lib/mysql \
				-e MYSQL_ROOT_PASSWORD=812KKKlm102 \
				-e MYSQL_DATABASE=wordpress \
				-d mysql
			docker run \
				-e WORDPRESS_DB_PASSWORD=812KKKlm102 \
				--name wordpress \
				--link wordpressdb:mysql \
				-p 127.0.0.2:8080:80 \
				-v $PWD/:/var/www/html \
				-d wordpress
		;;
	esac;
fi;
