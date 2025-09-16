# 📧 Configuración de Gmail para Envío de Emails

## ⚠️ IMPORTANTE: Configuración de Contraseña de Aplicación

Para que los emails se envíen desde tu cuenta de Gmail (`edu300572@gmail.com`), necesitas crear una **contraseña de aplicación** porque Gmail no permite usar tu contraseña normal por seguridad.

### 🔧 Pasos para Configurar la Contraseña de Aplicación:

#### 1. **Activar la Verificación en 2 Pasos**
1. Ve a tu cuenta de Google: https://myaccount.google.com/
2. Ve a **Seguridad** → **Verificación en 2 pasos**
3. Actívala si no está activada

#### 2. **Crear Contraseña de Aplicación**
1. En la misma sección de **Seguridad**
2. Busca **Contraseñas de aplicaciones**
3. Selecciona **Aplicación**: "Correo"
4. Selecciona **Dispositivo**: "Otro (nombre personalizado)"
5. Escribe: "Filá Mariscales - Web"
6. Haz clic en **Generar**

#### 3. **Copiar la Contraseña Generada**
- Gmail te dará una contraseña de 16 caracteres (ejemplo: `abcd efgh ijkl mnop`)
- **Copia esta contraseña** (sin espacios)

#### 4. **Actualizar el Archivo de Configuración**
1. Abre el archivo: `src/config/email_config.php`
2. Busca la línea:
   ```php
   define('SMTP_PASSWORD', 'tu-contraseña-de-aplicacion');
   ```
3. Reemplaza `tu-contraseña-de-aplicacion` con la contraseña de 16 caracteres que copiaste:
   ```php
   define('SMTP_PASSWORD', 'abcdefghijklmnop');
   ```

### 🧪 **Probar el Sistema**

Una vez configurado, puedes probar:

1. **Prueba básica**: Ve a `http://localhost/prueba-php/public/test-email.php`
2. **Prueba real**: Usa el formulario de suscripción en la página de noticias

### 📋 **Configuración Actual**

```php
// Tu configuración actual:
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'edu300572@gmail.com');
define('SMTP_PASSWORD', 'AQUI-VA-TU-CONTRASEÑA-DE-APLICACION');
define('SMTP_ENCRYPTION', 'tls');
define('DEVELOPMENT_MODE', false); // Activado para envío real
```

### ⚠️ **Notas Importantes**

- **Nunca compartas** tu contraseña de aplicación
- **Guárdala en un lugar seguro**
- Si cambias la contraseña de tu cuenta de Google, tendrás que generar una nueva contraseña de aplicación
- Los emails se enviarán desde `edu300572@gmail.com` con el nombre "Filá Mariscales de Caballeros Templarios"

### 🆘 **Si Tienes Problemas**

1. **Verifica que la verificación en 2 pasos esté activada**
2. **Asegúrate de copiar la contraseña sin espacios**
3. **Revisa que el archivo de configuración esté guardado correctamente**
4. **Prueba primero con el archivo de test-email.php**

### ✅ **Una Vez Configurado**

- Los emails de suscripción se enviarán automáticamente
- Los usuarios recibirán un email de bienvenida profesional
- Las suscripciones se guardarán en la base de datos
- Podrás gestionar las suscripciones desde el panel de administración
