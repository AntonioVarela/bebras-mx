# Solución de Error 404 en Laravel Cloud con Nginx

## Problema
Error 404 Not Found en Laravel Cloud con servidor nginx.

## Soluciones

### 1. Verificar Document Root en Laravel Cloud

En el panel de Laravel Cloud, asegúrate de que el **Document Root** esté configurado como:
```
/var/www/html/public
```
O la ruta equivalente donde está tu carpeta `public`.

### 2. Configuración Nginx

Laravel Cloud debería usar automáticamente la configuración correcta, pero si necesitas configurarla manualmente, usa el archivo `laravel-cloud-nginx.conf` que se creó en la raíz del proyecto.

**Puntos importantes:**
- El `root` debe apuntar a `/var/www/html/public` (o tu ruta equivalente)
- La directiva `try_files` debe incluir `/index.php?$query_string`
- El socket de PHP-FPM puede variar según la versión (php8.1-fpm.sock, php8.2-fpm.sock, etc.)

### 3. Verificar Variables de Entorno

Asegúrate de que en Laravel Cloud tengas configurado:
```
APP_URL=https://tu-dominio.com
APP_ENV=production
```

### 4. Verificar Permisos

Los permisos de archivos deben ser:
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 5. Limpiar Cachés

Ejecuta estos comandos en Laravel Cloud:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize:clear
```

### 6. Verificar Rutas

Asegúrate de que las rutas estén correctamente definidas en `routes/web.php`.

### 7. Verificar que index.php existe

Confirma que el archivo `public/index.php` existe y tiene el contenido correcto.

## Configuración Recomendada para Laravel Cloud

1. **Document Root:** `/var/www/html/public`
2. **PHP Version:** 8.2 o superior
3. **Node Version:** 18.x o superior (para compilar assets)

## Comandos Útiles en Laravel Cloud

```bash
# Ver logs de nginx
tail -f /var/log/nginx/error.log

# Ver logs de Laravel
tail -f storage/logs/laravel.log

# Verificar configuración de nginx
nginx -t

# Reiniciar nginx (si tienes acceso)
sudo systemctl restart nginx
```

## Contacto con Soporte

Si el problema persiste, contacta al soporte de Laravel Cloud con:
- El mensaje de error completo
- La URL que está fallando
- Los logs de nginx y Laravel

