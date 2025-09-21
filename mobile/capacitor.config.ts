import { CapacitorConfig } from '@capacitor/core';

const config: CapacitorConfig = {
  appId: 'com.filamariscales.app',
  appName: 'Mariscales',
  webDir: 'www',
  bundledWebRuntime: false,
  server: {
    // URL de la web. Para desarrollo local puedes usar tu IP local
    // Ejemplos:
    // - 'http://localhost/prueba-php/public'
    // - 'http://192.168.1.34/prueba-php/public'
    // En producción, usa siempre HTTPS
    url: 'http://localhost/prueba-php/public',
    cleartext: true
  },
};

export default config;
