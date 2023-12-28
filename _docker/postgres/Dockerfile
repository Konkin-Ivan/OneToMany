FROM postgres:latest

COPY /postgresql.conf      /tmp/postgresql.conf
COPY /postgresql.conf      /var/lib/postgresql/data/pgdata/postgresql.conf
COPY /updateConfig.sh      /docker-entrypoint-initdb.d/_updateConfig.sh