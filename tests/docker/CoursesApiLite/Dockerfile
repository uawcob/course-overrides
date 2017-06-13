FROM ubuntu:16.04

RUN apt-get update && \
    apt-get install -y php && \
    apt-get autoremove -y && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY index.php courses /srv/

WORKDIR /srv

CMD php -S 0.0.0.0:80 -t .
