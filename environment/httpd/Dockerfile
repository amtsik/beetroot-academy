FROM httpd:alpine

#RUN apt update
#RUN a2enmod rewrite

#COPY ./environment/httpd/httpd.conf /etc/apache2/sites-available/000-default.conf
COPY ./environment/httpd/httpd.conf /usr/local/apache2/conf/httpd.conf

RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
        { \
          echo 'IncludeOptional conf.d/*.conf'; \
        } >> /usr/local/apache2/conf/httpd.conf \
          && mkdir /usr/local/apache2/conf.d

WORKDIR /var/www/html