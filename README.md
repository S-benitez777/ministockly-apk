
# MiniStockly → PWA → APK (sin Android Studio para programar)

> Este proyecto toma tu MiniStockly y lo deja listo como **PWA** de alta calidad,
> y con **Capacitor** para compilar a **APK**.

## 0. Estructura final
```
MiniStockly/
 ├─ public/                ← Tu app web servida como PWA
 │   ├─ index.html
 │   ├─ manifest.webmanifest
 │   ├─ service-worker.js
 │   └─ icons/
 ├─ src/                   ← (opcional para tu código fuente)
 ├─ package.json
 └─ capacitor.config.json
```

## 1. Probar como PWA en tu PC
```bash
npm run serve
# Abre http://localhost:5173
# Instala la PWA desde el navegador (botón Instalar o menú)
```

## 2. Preparar Capacitor y Android (una sola vez)
```bash
npm install
npm run cap:add:android
```

> Si no tienes Android Studio, basta con las herramientas de línea de comandos.
> Luego, para compilar APK:
```bash
cd android
./gradlew assembleDebug
# APK: android/app/build/outputs/apk/debug/app-debug.apk
```

## 3. Sincronizar cambios web a la app nativa
```bash
npm run cap:copy
```

## 4. Compilar e instalar en el teléfono
- Opción A: Copia el APK al móvil y tócalo para instalar (activa “orígenes desconocidos”).
- Opción B: Por ADB
```bash
adb install android/app/build/outputs/apk/debug/app-debug.apk
```

## 5. Consejos de calidad
- Mantén manifest e iconos correctos (192/512).
- El service worker ya usa caché para shell + fallback offline.
- Versiona el caché si cambias archivos (ministockly-v2, v3…).
- Prueba Lighthouse (Chrome) para PWA y performance.
