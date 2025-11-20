# 📘 Documentación Técnica de Objetos y Propiedades del Navegador

Esta documentación cubre de manera técnica y completa los objetos y propiedades más relevantes del entorno **`window`** en JavaScript:  
`screen`, `history`, `console`, `navigator`, `screenX`, `screenY`, `scrollX` y `scrollY`.

Se presenta con **tablas de propiedades y métodos**, **sintaxis** y **ejemplos de uso modernos**.

---

## 🖥️ Objeto `screen`

### 🔹 Descripción
Proporciona información sobre la pantalla física del dispositivo.

### 🔹 Sintaxis
```javascript
window.screen
```

### 🔹 Propiedades principales
| Propiedad | Descripción | Ejemplo |
|------------|------------|---------|
| `width` | Ancho total de la pantalla en píxeles. | `screen.width` |
| `height` | Altura total de la pantalla en píxeles. | `screen.height` |
| `availWidth` | Ancho disponible (sin barras de tareas, docks, etc.). | `screen.availWidth` |
| `availHeight` | Altura disponible. | `screen.availHeight` |
| `colorDepth` | Profundidad de color en bits por píxel. | `screen.colorDepth` |
| `pixelDepth` | Igual que `colorDepth`. | `screen.pixelDepth` |
| `orientation` | Objeto que describe la orientación de la pantalla. | `screen.orientation.type` |
| `orientation.angle` | Ángulo de rotación de la pantalla. | `screen.orientation.angle` |

### 🔹 Ejemplo
```javascript
console.log(`Resolución total: ${screen.width}x${screen.height}`);
console.log(`Resolución disponible: ${screen.availWidth}x${screen.availHeight}`);
console.log(`Profundidad de color: ${screen.colorDepth}`);
console.log(`Orientación: ${screen.orientation.type}, ángulo: ${screen.orientation.angle}`);
```

---

## 📜 Objeto `history`

### 🔹 Descripción
Permite acceder y manipular el historial de navegación de la pestaña actual.

### 🔹 Sintaxis
```javascript
window.history
```

### 🔹 Propiedades y métodos
| Propiedad / Método | Descripción | Ejemplo |
|------------------|-------------|---------|
| `length` | Número de entradas en el historial. | `history.length` |
| `back()` | Navega a la página anterior. | `history.back()` |
| `forward()` | Navega a la página siguiente. | `history.forward()` |
| `go(n)` | Navega `n` pasos en el historial (positivo o negativo). | `history.go(-2)` |
| `scrollRestoration` | Controla restauración de posición de scroll (`auto` o `manual`). | `history.scrollRestoration = "manual"` |

### 🔹 Ejemplo
```javascript
console.log(`Entradas en historial: ${history.length}`);
history.back();  // Retrocede una página
history.go(-2);  // Retrocede dos páginas
```

---

## 🧭 Objeto `navigator`

### 🔹 Descripción
Contiene información sobre el navegador y entorno del usuario.

### 🔹 Sintaxis
```javascript
window.navigator
```

### 🔹 Propiedades principales
| Propiedad | Descripción | Ejemplo |
|------------|-------------|---------|
| `userAgent` | Cadena con información del navegador y SO. | `navigator.userAgent` |
| `platform` | Sistema operativo. | `navigator.platform` |
| `language` | Idioma preferido del navegador. | `navigator.language` |
| `languages` | Array de idiomas preferidos. | `navigator.languages` |
| `onLine` | Indica si hay conexión a Internet. | `navigator.onLine` |
| `cookieEnabled` | Indica si las cookies están habilitadas. | `navigator.cookieEnabled` |
| `hardwareConcurrency` | Número de núcleos de CPU disponibles. | `navigator.hardwareConcurrency` |
| `deviceMemory` | Memoria RAM aproximada en GB. | `navigator.deviceMemory` |
| `maxTouchPoints` | Número máximo de puntos táctiles simultáneos. | `navigator.maxTouchPoints` |
| `connection` | Objeto que indica estado de la red. | `navigator.connection.downlink` |

### 🔹 Ejemplo
```javascript
console.log(`Navegador: ${navigator.userAgent}`);
console.log(`Plataforma: ${navigator.platform}`);
console.log(`Idioma: ${navigator.language}`);
console.log(`Conectado: ${navigator.onLine}`);
console.log(`CPU cores: ${navigator.hardwareConcurrency}`);
console.log(`Memoria aprox.: ${navigator.deviceMemory} GB`);
```

---

## 🧰 Objeto `console`

### 🔹 Descripción
Proporciona métodos para depuración y salida de información en la consola.

### 🔹 Sintaxis
```javascript
console.log("mensaje")
```

### 🔹 Métodos comunes
| Método | Descripción | Ejemplo |
|--------|------------|---------|
| `log()` | Mensaje general. | `console.log("Hola")` |
| `error()` | Mensaje de error. | `console.error("Error!")` |
| `warn()` | Mensaje de advertencia. | `console.warn("Cuidado!")` |
| `info()` | Mensaje informativo. | `console.info("Info")` |
| `table()` | Muestra datos en tabla. | `console.table([{a:1,b:2},{a:3,b:4}])` |
| `group()` / `groupEnd()` | Agrupa mensajes. | `console.group("Grupo"); console.log("Msg"); console.groupEnd();` |
| `time()` / `timeEnd()` | Cronometrar operaciones. | `console.time("T"); doSomething(); console.timeEnd("T");` |
| `clear()` | Limpia la consola. | `console.clear()` |

### 🔹 Ejemplo
```javascript
console.group("Depuración");
console.log("Mensaje 1");
console.warn("Advertencia");
console.error("Error");
console.groupEnd();
console.table([{a:1,b:2},{a:3,b:4}]);
```

---

## 📍 Propiedades `screenX` y `screenY`

| Propiedad | Descripción | Ejemplo |
|------------|------------|---------|
| `screenX` | Posición horizontal de la ventana respecto a la pantalla. | `window.screenX` |
| `screenY` | Posición vertical de la ventana respecto a la pantalla. | `window.screenY` |

### 🔹 Ejemplo
```javascript
console.log(`Posición de ventana: X=${screenX}, Y=${screenY}`);
```

---

## 🧾 Propiedades `scrollX` y `scrollY`

| Propiedad | Descripción | Ejemplo |
|------------|------------|---------|
| `scrollX` | Desplazamiento horizontal del documento en píxeles. | `window.scrollX` |
| `scrollY` | Desplazamiento vertical del documento en píxeles. | `window.scrollY` |

### 🔹 Ejemplo
```javascript
console.log(`Desplazamiento actual: X=${scrollX}, Y=${scrollY}`);
window.scrollTo(0, 100); // Desplaza la página verticalmente
```

---

## 📚 Notas finales
- Todos los objetos pertenecen al **objeto global `window`**.  
- Se puede omitir `window.` en la mayoría de los casos (ej.: `screen.width` en lugar de `window.screen.width`).

