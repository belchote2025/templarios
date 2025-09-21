# Mariscales Mobile (Capacitor)

Este proyecto crea un contenedor Android (APK) para la web de Filá Mariscales utilizando Capacitor.

La app cargará la web existente (PHP) a través de un WebView seguro apuntando a la URL del sitio.

## Requisitos
- Node.js 18+
- Android Studio + Android SDK (Build-Tools, Platform-Tools)
- Java 11 o superior
- Dispositivo o emulador Android

## Configuración rápida
1) Instalar dependencias
```
npm install
```

2) Configurar la URL del sitio en `capacitor.config.ts`
- Por defecto apunta a `http://localhost/prueba-php/public`
- En producción, usa un dominio HTTPS (recomendado) para mejor compatibilidad y seguridad

3) Añadir plataforma Android
```
npx cap add android
```

4) Sincronizar cambios y abrir Android Studio
```
npx cap sync android
npx cap open android
```

5) Compilar APK en Android Studio
- Build > Build Bundle(s) / APK(s) > Build APK(s)
- El APK de debug quedará en `app/build/outputs/apk/` (por defecto)

## Cambiar iconos/splash
- Reemplaza los recursos en `android/app/src/main/res/mipmap-*` tras `npx cap add android`
- Opcionalmente, usa Android Studio > Image Asset para generar variantes

## Notificaciones y plugins nativos
- Se pueden añadir plugins Capacitor (FCM, cámara, etc.)
- Tras instalar cualquier plugin, ejecuta `npx cap sync`

## Resolución de problemas
- Si la web no carga:
  - Verifica que la URL sea accesible desde el dispositivo.
  - Preferir `https://` en producción.
- Si no compila en Android Studio:
  - Acepta licencias y actualiza SDK/Build-tools.
  - Verifica versión de Gradle/Java recomendadas por Android Studio.

## Estructura
- `capacitor.config.ts` -> configuración principal (appId, appName, server.url)
- `www/` -> (opcional) carpeta web estática. Aquí no se usa, ya que apuntamos a `server.url`.
- `android/` -> creado por Capacitor al añadir plataforma

## Comandos útiles
```
npx cap doctor
npx cap copy android
npx cap sync android
npx cap open android
```

## Seguridad
- Si usas HTTP en local, habilita temporalmente `cleartextTrafficPermitted` en el `AndroidManifest.xml` o usa `http://10.0.2.2/...` en emulador.
- En producción, usa HTTPS y deshabilita tráfico en claro.
