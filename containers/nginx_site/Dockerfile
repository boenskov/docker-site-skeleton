FROM nginx:1.11

#EXPOSE 443
EXPOSE 80

COPY ./conf /etc/nginx/conf.d/

#RUN chown -R www-data:www-data /var/www

#CMD chown -R www-data:www-data /var/www/tender-files && chown -R www-data:www-data /var/www/user-files && nginx -g "daemon off;"
#CMD chown -R www-data:www-data /var/www && nginx -g "daemon off;"
#CMD nginx -g "daemon off;"
