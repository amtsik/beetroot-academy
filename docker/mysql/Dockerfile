#FROM percona:latest
#FROM mysql:latest

#ADD ./data /var/lib/mysql
#ADD ./my.cnf /etc/mysql/conf.d/my.cnf
#ADD ./logs /var/log/mysql

#RUN chown mysql:mysql /etc/mysql/my.cnf
#RUN chmod -R 0444 /etc/mysql/
#RUN chown mysql:mysql /var/lib/mysql
#RUN chmod -R 750 /var/lib/mysql

#ENTRYPOINT mysqld --skip-symbolic-links --skip-external-locking

#ENTRYPOINT mysqld --initialize-insecure  --console --skip-symbolic-links

#ENTRYPOINT mysqld --initialize && mysqld --skip-mysqlx --default-authentication-plugin=mysql_native_password
#ENTRYPOINT ls -la /var/lib/mysql


#VOLUME /var/lib/mysql
#WORKDIR /var/lib/mysql
